<?php

namespace App\Http\Controllers;

use App\Models\Service; // Assuming Service model will be created
use Illuminate\Http\Request;

/**
 * ServiceController manages the display of services to users (category listing, individual service details)
 * and handles CRUD operations for services by vendors and potentially admins.
 */
class ServiceController extends Controller
{
    /**
     * Display a listing of services by category.
     *
     * @param string $category
     * @return \Illuminate\View\View
     */
    public function category(Request $request, $categorySlug)
    {
        $query = Service::with('vendor', 'images')->live(); // Use the 'live' scope

        if ($categorySlug !== 'all') {
            $query->where('category', $categorySlug);
        }

        // Basic filtering examples (can be expanded)
        if ($request->filled('price_from')) {
            $query->where('price_from', '>=', $request->input('price_from'));
        }
        if ($request->filled('price_to')) {
            $query->where('price_to', '<=', $request->input('price_to'));
        }
        if ($request->filled('location_filter')) {
            // This is a simple location text search, could be more advanced
            $query->where('location_text', 'LIKE', '%' . $request->input('location_filter') . '%');
        }
        // Add rating filter if Review model and relationships are set up for average rating
        // e.g. if ($request->filled('min_rating')) { $query->whereHas('reviews', fn($q) => $q->havingRaw('AVG(rating) >= ?', [$request->input('min_rating')])); }


        // Sorting
        $sortBy = $request->input('sort_by', 'default');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price_from', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_from', 'desc'); // or price_to
                break;
            case 'rating_desc':
                // Requires average rating calculation, e.g., with a subquery or a dedicated column
                // $query->orderBy('average_rating', 'desc'); // Placeholder
                $query->orderBy('created_at', 'desc'); // Fallback
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $services = $query->paginate(12)->appends($request->query()); // 12 items per page, append query string for filters

        $categoryTitle = ($categorySlug === 'all') ? __('All Services') : Str::title(str_replace('-', ' ', $categorySlug));

        return view('services.category', [
            'services' => $services,
            'category' => $categorySlug, // The slug
            'categoryTitle' => $categoryTitle, // For display
            'filters' => $request->all() // Pass current filters back to the view
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
            ->where('category', $service->category)
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
