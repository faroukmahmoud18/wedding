<?php

// Intended Path: app/Http/Controllers/API/VendorController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor; // Assuming your model is here
use App\Models\Service; // If listing services by vendor
use Illuminate\Http\Request;
// use App\Http\Resources\VendorResource; // Optional
// use App\Http\Resources\ServiceResource; // Optional

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/vendors
     */
    public function index(Request $request)
    {
        // Basic implementation: Paginate vendors
        // Add filtering, search query, etc. as needed
        $vendors = Vendor::paginate(15);
        // return VendorResource::collection($vendors);
        return response()->json($vendors);
    }

    /**
     * Display the specified resource.
     * GET /api/vendors/{id}
     */
    public function show(Vendor $vendor) // Route model binding
    {
        // Eager load services if needed for the profile page
        // $vendor->load('services');
        // return new VendorResource($vendor);
        return response()->json($vendor);
    }

    /**
     * Display services for a specific vendor.
     * GET /api/vendors/{id}/services
     */
    public function services(Vendor $vendor) // Route model binding
    {
        // $services = $vendor->services()->paginate(10); // Assuming 'services' relationship exists on Vendor model
        // return ServiceResource::collection($services);
        return response()->json(['message' => 'Placeholder for services by vendor ' . $vendor->id], 501);
    }

    // Admin-only CRUD for vendors would typically be in a separate Admin\VendorController
    // Public API might not have store/update/destroy for vendors unless it's a vendor registration endpoint.
}
