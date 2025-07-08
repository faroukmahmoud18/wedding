<?php

// Intended Path: app/Http/Controllers/API/Admin/ServiceController.php
namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
// use App\Http\Resources\ServiceResource; // Optional

class ServiceController extends Controller
{
    // Ensure this controller's routes are protected by admin middleware

    /**
     * Display a listing of all services for admin.
     * GET /api/admin/services
     */
    public function index(Request $request)
    {
        // Add search, filtering by vendor/category, sorting as needed
        // $services = Service::with('vendor')->latest()->paginate(20);
        // return ServiceResource::collection($services);
        return response()->json(['message' => 'Admin: Placeholder for listing all services.'], 501);
    }

    /**
     * Display the specified service for admin.
     * GET /api/admin/services/{id}
     */
    public function show(Service $service)
    {
        // $service->load('vendor');
        // return new ServiceResource($service);
        return response()->json(['message' => 'Admin: Placeholder for showing service ' . $service->id], 501);
    }

    /**
     * Update the specified service (e.g., approve, change details by admin).
     * PUT /api/admin/services/{id}
     */
    public function update(Request $request, Service $service)
    {
        // $validatedData = $request->validate([
        //     'title' => 'sometimes|required|string|max:255',
        //     'category' => 'sometimes|required|string',
        //     'is_active' => 'sometimes|boolean', // For approve/disable
        //     'featured' => 'sometimes|boolean',
        //     // Potentially other fields admin can edit
        // ]);
        // $service->update($validatedData);
        // return new ServiceResource($service);
        return response()->json(['message' => 'Admin: Placeholder for updating service ' . $service->id], 501);
    }

    /**
     * Toggle service active status (approve/disable).
     * PATCH /api/admin/services/{id}/toggle-active
     */
    public function toggleActive(Service $service)
    {
        // $service->is_active = !$service->is_active;
        // $service->save();
        // return new ServiceResource($service);
        return response()->json(['message' => 'Admin: Placeholder for toggling active status for service ' . $service->id], 501);
    }

    /**
     * Toggle service featured status.
     * PATCH /api/admin/services/{id}/toggle-featured
     */
    public function toggleFeatured(Service $service)
    {
        // $service->featured = !$service->featured;
        // $service->save();
        // return new ServiceResource($service);
        return response()->json(['message' => 'Admin: Placeholder for toggling featured status for service ' . $service->id], 501);
    }


    /**
     * Remove the specified service from storage.
     * DELETE /api/admin/services/{id}
     */
    public function destroy(Service $service)
    {
        // $service->delete();
        // return response()->json(null, 204);
        return response()->json(['message' => 'Admin: Placeholder for deleting service ' . $service->id], 501);
    }
}
