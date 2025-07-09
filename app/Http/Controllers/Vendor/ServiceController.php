<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceImage; // Assuming you might have a model for multiple images
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    private function getVendor() {
        $vendor = Auth::user()->vendor;
        if (!$vendor) {
            // This should ideally be caught by middleware if route is vendor-specific
            abort(403, 'User is not a vendor or vendor profile not found.');
        }
        return $vendor;
    }

    /**
     * Display a listing of the vendor's services.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $vendor = $this->getVendor();
        $query = $vendor->services()->with('category', 'images')->orderBy('created_at', 'desc');

        // Filtering by status for vendor's view
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $services = $query->paginate(10)->appends($request->query());

        return view('vendor.services.index', compact('services', 'vendor'));
    }

    /**
     * Show the form for creating a new service.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $vendor = $this->getVendor();
        $categories = Category::orderBy('name')->get();
        return view('vendor.services.create', compact('vendor', 'categories'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $vendor = $this->getVendor();

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'short_desc' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_unit' => 'nullable|string|max:50',
            'location_text' => 'nullable|string|max:255',
            'tags' => 'nullable|string', // Consider processing into array
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            // 'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048' // For multiple images
        ]);

        $service = new Service($validatedData);
        $service->vendor_id = $vendor->id;
        $service->slug = Str::slug($validatedData['title']); // Will be auto-updated by mutator if title changes
        $service->status = 'pending_approval'; // New services default to pending
        $service->is_live = false; // Not live until approved

        if ($request->hasFile('featured_image')) {
            $service->featured_image_path = $request->file('featured_image')->store('services/featured', 'public');
        }

        // Process tags string into JSON array if desired
        if(!empty($validatedData['tags'])) {
            $service->tags = array_map('trim', explode(',', $validatedData['tags']));
        } else {
            $service->tags = [];
        }

        $service->save();

        // Handle additional images if any
        // if ($request->hasFile('additional_images')) {
        //     foreach ($request->file('additional_images') as $file) {
        //         $path = $file->store('services/additional', 'public');
        //         $service->images()->create(['image_path' => $path]); // Assumes ServiceImage model and relationship
        //     }
        // }

        return redirect()->route('vendor.services.index')->with('success', __('Service submitted successfully. It will be reviewed by an admin.'));
    }

    /**
     * Display the specified service (vendor's own).
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View
     */
    public function show(Service $service)
    {
        $vendor = $this->getVendor();
        // Ensure the service belongs to the authenticated vendor
        if ($service->vendor_id !== $vendor->id) {
            abort(403, 'You do not own this service.');
        }
        $service->load('category', 'images', 'bookings', 'reviews'); // Eager load details
        return view('vendor.services.show', compact('service', 'vendor'));
    }

    /**
     * Show the form for editing the specified service.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View
     */
    public function edit(Service $service)
    {
        $vendor = $this->getVendor();
        if ($service->vendor_id !== $vendor->id) {
            abort(403, 'You do not own this service.');
        }

        // Vendor should not be able to change status directly, but can edit other details.
        // If a service is 'rejected', they might be able to edit and resubmit.
        // if ($service->status === 'approved' && $service->is_live) {
        //     return redirect()->route('vendor.services.index')->with('error', 'Live services cannot be edited directly. Please contact admin or unpublish first.');
        // }

        $categories = Category::orderBy('name')->get();
        return view('vendor.services.edit', compact('service', 'vendor', 'categories'));
    }

    /**
     * Update the specified service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Service $service)
    {
        $vendor = $this->getVendor();
        if ($service->vendor_id !== $vendor->id) {
            abort(403, 'You do not own this service.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'short_desc' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_unit' => 'nullable|string|max:50',
            'location_text' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            // 'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        $service->fill($validatedData);
        // $service->slug = Str::slug($validatedData['title']); // Handled by mutator

        if ($request->hasFile('featured_image')) {
            // Consider deleting old featured image: Storage::disk('public')->delete($service->featured_image_path);
            $service->featured_image_path = $request->file('featured_image')->store('services/featured', 'public');
        }

        if(!empty($validatedData['tags'])) {
            $service->tags = array_map('trim', explode(',', $validatedData['tags']));
        } else {
            $service->tags = [];
        }

        // If a service was rejected or on hold, editing it might put it back to pending_approval
        if (in_array($service->status, ['rejected', 'on_hold'])) {
            $service->status = 'pending_approval';
            $service->is_live = false; // Ensure it's not live after edit if it was rejected/on_hold
            $service->rejection_reason = null; // Clear previous rejection reason
        } elseif ($service->status === 'approved') {
            // If an approved service is edited, it might need re-approval depending on policy
            // For now, let's assume minor edits on approved (but offline) services are okay.
            // If it's live, major edits might require taking it offline and re-approval.
            // This policy needs to be defined. For simplicity, we'll mark it as pending if it was approved.
            $service->status = 'pending_approval'; // Or keep 'approved' and set a flag 'requires_review'
            $service->is_live = false;
        }


        $service->save();

        // Handle updates to additional images (deletion, new uploads) - more complex logic

        return redirect()->route('vendor.services.index')->with('success', __('Service updated successfully. It may require re-approval if significant changes were made.'));
    }

    /**
     * Remove the specified service from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        $vendor = $this->getVendor();
        if ($service->vendor_id !== $vendor->id) {
            abort(403, 'You do not own this service.');
        }

        // Business logic: Can a live service be deleted? What about bookings?
        // if ($service->is_live || $service->bookings()->where('status', 'confirmed')->exists()) {
        //    return redirect()->route('vendor.services.index')->with('error', 'Cannot delete service with active bookings or if it is live. Please contact support or unpublish first.');
        // }

        // Consider soft delete or archiving instead of hard delete
        // if($service->featured_image_path) Storage::disk('public')->delete($service->featured_image_path);
        // $service->images()->each(function($image) { Storage::disk('public')->delete($image->image_path); $image->delete(); }); // Delete additional images

        $service->delete();

        return redirect()->route('vendor.services.index')->with('success', __('Service deleted successfully.'));
    }
}
