<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category; // Added Category model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Added Str facade

/**
 * ServiceController manages the display of services to users (category listing, individual service details)
 * and handles CRUD operations for services by vendors and potentially admins.
 */
class ServiceController extends Controller
{
    /**
     * Display a listing of services by category.
     *
     * @param string $categorySlug
     * @return \Illuminate\View\View
     */
    public function category(Request $request, $categorySlug)
    {
        $currentCategory = null;
        $query = Service::with('vendor', 'images', 'category')->live(); // Use the 'live' scope, include category relationship

        if ($categorySlug !== 'all') {
            $currentCategory = Category::where('slug', $categorySlug)->firstOrFail();
            $query->where('category_id', $currentCategory->id);
        }

        // Filtering
        $location = $request->input('location');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        if ($location) {
            $query->where('location_text', 'LIKE', "%{$location}%");
        }
        if ($min_price) {
            $query->where('price', '>=', $min_price); // Assuming 'price' field exists
        }
        if ($max_price) {
            $query->where('price', '<=', $max_price); // Assuming 'price' field exists
        }
        // Add rating filter if Review model and relationships are set up for average rating
        // e.g. if ($request->filled('min_rating')) { $query->whereHas('reviews', fn($q) => $q->havingRaw('AVG(rating) >= ?', [$request->input('min_rating')])); }

        // Sorting
        $sort_by = $request->input('sort_by', 'new_first'); // Default to new_first
        switch ($sort_by) {
            case 'price_asc':
                $query->orderBy('price', 'asc'); // Assuming 'price' field
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc'); // Assuming 'price' field
                break;
            case 'new_first':
            default:
                $query->orderBy('created_at', 'desc');
        }

        $services = $query->paginate(12)->appends($request->query());

        $categoryName = $currentCategory ? $currentCategory->name : __('All Services');
        $allCategories = Category::orderBy('name')->get(); // For filter dropdown

        return view('services.category', [
            'services' => $services,
            'currentCategory' => $currentCategory,
            'categoryName' => $categoryName, // For display
            'categories' => $allCategories, // For filter dropdown
            'categorySlug' => $categorySlug, // Pass slug for form actions
            // Pass individual filter values for easy access in the view
            'location' => $location,
            'min_price' => $min_price,
            'max_price' => $max_price,
            'sort_by' => $sort_by,
        ]);
    }

    /**
     * Display the specified service.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $service = Service::with([
            'vendor' => function ($query) {
                $query->active(); // Only show if vendor is active
            },
            'images',
            'reviews' => function ($query) {
                $query->approved()->with('user')->latest(); // Approved reviews with user, latest first
            }
        ])
        ->live() // Service itself must be live
        ->where('slug', $slug)
        ->firstOrFail();

        // Potentially load related services as well
        $relatedServices = Service::with('vendor', 'images')
            ->live()
            ->where('category_id', $service->category_id) // Corrected to use category_id
            ->where('id', '!=', $service->id) // Exclude current service
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }

    /**
     * Display a listing of the resource for vendors.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Logic for vendor to view their services
        // Example: $services = auth()->user()->vendor->services()->paginate(10); // Assuming user is a vendor
        // return view('vendor.services.index', compact('services'));
        return view('vendor.services.index');
    }

    /**
     * Show the form for creating a new resource for vendors.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Logic to show service creation form for vendors
        // return view('vendor.services.create');
        return view('vendor.services.create');
    }

    /**
     * Store a newly created resource in storage for vendors.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Logic to store a new service for vendors
        // Example: $validatedData = $request->validate([...]);
        // auth()->user()->vendor->services()->create($validatedData);
        // return redirect()->route('vendor.services.index')->with('success', __('Service created successfully.'));
        return redirect()->route('vendor.services.index');
    }

    /**
     * Show the form for editing the specified resource for vendors.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Logic to show service edit form for vendors
        // Example: $service = Service::findOrFail($id);
        // $this->authorize('update', $service); // Policy for authorization
        // return view('vendor.services.edit', compact('service'));
        return view('vendor.services.edit', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage for vendors.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Logic to update a service for vendors
        // Example: $validatedData = $request->validate([...]);
        // $service = Service::findOrFail($id);
        // $this->authorize('update', $service); // Policy for authorization
        // $service->update($validatedData);
        // return redirect()->route('vendor.services.index')->with('success', __('Service updated successfully.'));
        return redirect()->route('vendor.services.index');
    }

    /**
     * Remove the specified resource from storage for vendors.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Logic to delete a service for vendors
        // Example: $service = Service::findOrFail($id);
        // $this->authorize('delete', $service); // Policy for authorization
        // $service->delete();
        // return redirect()->route('vendor.services.index')->with('success', __('Service deleted successfully.'));
        return redirect()->route('vendor.services.index');
    }
}
