<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Service::with('vendor', 'category')->orderBy('created_at', 'desc');

        // Filtering
        if ($request->filled('status')) {
            if ($request->status !== 'all') {
                 $query->where('status', $request->status);
            }
        } else {
            // Default to showing pending if no status is set, or all, depending on preference
            // $query->where('status', 'pending_approval');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('description', 'LIKE', $searchTerm)
                  ->orWhereHas('vendor', function($vendorQuery) use ($searchTerm) {
                      $vendorQuery->where('name', 'LIKE', $searchTerm);
                  });
            });
        }

        $services = $query->paginate(15)->appends($request->query());
        $categories = Category::orderBy('name')->get();
        $vendors = Vendor::orderBy('name')->get(); // For filter dropdown

        return view('admin.services.index', compact('services', 'categories', 'vendors'));
    }

    /**
     * Display the specified service.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View
     */
    public function show(Service $service)
    {
        $service->load('vendor', 'category', 'images', 'reviews', 'bookings');
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View
     */
    public function edit(Service $service)
    {
        $categories = Category::orderBy('name')->get();
        $vendors = Vendor::orderBy('name')->get(); // In case admin needs to reassign
        return view('admin.services.edit', compact('service', 'categories', 'vendors'));
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'vendor_id' => 'required|exists:vendors,id', // Admin can change vendor
            'description' => 'required|string',
            'short_desc' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_unit' => 'nullable|string|max:50',
            'location_text' => 'nullable|string|max:255',
            'tags' => 'nullable|string', // Consider processing into array if stored as JSON
            'status' => 'required|in:pending_approval,approved,rejected,on_hold',
            'rejection_reason' => 'nullable|string|max:1000|required_if:status,rejected',
            'is_live' => 'sometimes|boolean',
            // Add validation for images if handling uploads here
        ]);

        $service->fill($validatedData);
        $service->is_live = $request->has('is_live');
        if ($service->status !== 'rejected') {
            $service->rejection_reason = null;
        }
        // $service->slug = Str::slug($validatedData['title']); // Handled by mutator/observer

        // Handle image uploads if necessary (more complex, involves file storage and potentially ServiceImage model)

        $service->save();

        return redirect()->route('admin.services.index')->with('success', __('Service updated successfully.'));
    }

    /**
     * Remove the specified service from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        // Consider implications: bookings for this service?
        // Soft delete is generally preferred.
        $service->delete(); // Or $service->update(['status' => 'archived']) etc.
        return redirect()->route('admin.services.index')->with('success', __('Service deleted successfully.'));
    }

    /**
     * Approve a pending service.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Service $service)
    {
        $service->status = 'approved';
        $service->is_live = true; // Typically, approving makes it live
        $service->rejection_reason = null;
        $service->save();

        // Notify vendor?
        // Mail::to($service->vendor->user->email)->send(new ServiceApproved($service));

        return redirect()->route('admin.services.index')->with('success', __('Service approved successfully.'));
    }

    /**
     * Reject a pending service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request, Service $service)
    {
        $request->validate(['rejection_reason' => 'required|string|max:1000']);

        $service->status = 'rejected';
        $service->is_live = false;
        $service->rejection_reason = $request->rejection_reason;
        $service->save();

        // Notify vendor?
        // Mail::to($service->vendor->user->email)->send(new ServiceRejected($service, $request->rejection_reason));

        return redirect()->route('admin.services.index')->with('success', __('Service rejected successfully.'));
    }

     /**
     * Toggle the live status of a service.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleLive(Service $service)
    {
        if ($service->status !== 'approved') {
            return redirect()->back()->with('error', __('Only approved services can be set live/offline.'));
        }
        $service->is_live = !$service->is_live;
        $service->save();
        $message = $service->is_live ? __('Service is now live.') : __('Service is now offline.');
        return redirect()->route('admin.services.index')->with('success', $message);
    }
}
