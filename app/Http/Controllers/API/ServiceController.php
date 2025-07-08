<?php

// Intended Path: app/Http/Controllers/API/ServiceController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service; // Assuming your model is here
use Illuminate\Http\Request;
// use App\Http\Resources\ServiceResource; // Optional: For API resource transformation

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/services
     */
    public function index(Request $request)
    {
        // Basic implementation: Paginate services
        // Add filtering by category, search query, etc. as needed
        // e.g., if ($request->has('category')) { ... }
        $services = Service::with('vendor')->paginate(15); // Eager load vendor
        // return ServiceResource::collection($services); // If using API Resources
        return response()->json($services);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/services (Likely an admin/vendor protected route)
     */
    public function store(Request $request)
    {
        // Add validation
        // $validatedData = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'vendor_id' => 'required|exists:vendors,id',
        //     'category' => 'required|string',
        //     'short_description' => 'nullable|string',
        //     'long_description' => 'nullable|string',
        //     'price_from' => 'required|numeric|min:0',
        //     // ... other fields
        // ]);

        // $service = Service::create($validatedData);
        // return new ServiceResource($service); // Or response()->json($service, 201);

        return response()->json(['message' => 'Placeholder for creating a service.'], 501); // 501 Not Implemented
    }

    /**
     * Display the specified resource.
     * GET /api/services/{id} or /api/services/{slug}
     */
    public function show($idOrSlug) // Can be ID or slug
    {
        // Find by ID or slug
        $service = Service::with('vendor')->where('id', $idOrSlug)->orWhere('slug', $idOrSlug)->first();

        if (!$service) {
            return response()->json(['message' => 'Service not found.'], 404);
        }
        // return new ServiceResource($service);
        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/services/{id} (Likely an admin/vendor protected route)
     */
    public function update(Request $request, Service $service) // Route model binding
    {
        // Add validation
        // $validatedData = $request->validate([ ... ]);
        // $service->update($validatedData);
        // return new ServiceResource($service);

        return response()->json(['message' => 'Placeholder for updating service ' . $service->id], 501);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/services/{id} (Likely an admin/vendor protected route)
     */
    public function destroy(Service $service) // Route model binding
    {
        // $service->delete();
        // return response()->json(null, 204); // No Content

        return response()->json(['message' => 'Placeholder for deleting service ' . $service->id], 501);
    }

    /**
     * Example: Get services by category slug.
     * GET /api/services/category/{categorySlug}
     */
    public function getByCategory(Request $request, $categorySlug)
    {
        // $services = Service::with('vendor')->where('category', $categorySlug)->paginate(15);
        // if ($services->isEmpty()) {
        //     return response()->json(['message' => 'No services found in this category.'], 404);
        // }
        // return ServiceResource::collection($services);
        return response()->json(['message' => 'Placeholder for services by category: ' . $categorySlug], 501);
    }
}
