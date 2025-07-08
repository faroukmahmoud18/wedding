<?php

// Intended Path: app/Http/Controllers/API/Admin/VendorController.php
namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
// use App\Http\Resources\VendorResource; // Optional

class VendorController extends Controller
{
    // Ensure this controller's routes are protected by admin middleware

    /**
     * Display a listing of the resource.
     * GET /api/admin/vendors
     */
    public function index(Request $request)
    {
        // Add search, filtering, sorting as needed
        // $vendors = Vendor::latest()->paginate(20);
        // return VendorResource::collection($vendors);
        return response()->json(['message' => 'Admin: Placeholder for listing all vendors.'], 501);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/admin/vendors
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email', // Assuming vendor has a user account
        //     'user_id' => 'nullable|exists:users,id|unique:vendors,user_id', // If linking to existing user
        //     // ... other vendor fields (about, phone, address, etc.)
        //     'verified' => 'sometimes|boolean',
        // ]);

        // // Logic to create a User for the vendor or link to existing one
        // // Then create the Vendor record
        // $vendor = Vendor::create($validatedData);
        // return new VendorResource($vendor);
        return response()->json(['message' => 'Admin: Placeholder for creating a vendor.'], 501);
    }

    /**
     * Display the specified resource.
     * GET /api/admin/vendors/{id}
     */
    public function show(Vendor $vendor)
    {
        // $vendor->load('services', 'user'); // Eager load related data
        // return new VendorResource($vendor);
        return response()->json(['message' => 'Admin: Placeholder for showing vendor ' . $vendor->id], 501);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/admin/vendors/{id}
     */
    public function update(Request $request, Vendor $vendor)
    {
        // $validatedData = $request->validate([ ... ]);
        // $vendor->update($validatedData);
        // return new VendorResource($vendor);
        return response()->json(['message' => 'Admin: Placeholder for updating vendor ' . $vendor->id], 501);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/admin/vendors/{id}
     */
    public function destroy(Vendor $vendor)
    {
        // $vendor->delete();
        // return response()->json(null, 204);
        return response()->json(['message' => 'Admin: Placeholder for deleting vendor ' . $vendor->id], 501);
    }

    /**
     * Toggle vendor verification status.
     * PATCH /api/admin/vendors/{id}/toggle-verification
     */
    public function toggleVerification(Vendor $vendor)
    {
        // $vendor->verified = !$vendor->verified;
        // $vendor->save();
        // return new VendorResource($vendor);
        return response()->json(['message' => 'Admin: Placeholder for toggling verification for vendor ' . $vendor->id], 501);
    }
     /**
     * Toggle vendor featured status.
     * PATCH /api/admin/vendors/{id}/toggle-featured
     */
    public function toggleFeatured(Vendor $vendor)
    {
        // $vendor->featured = !$vendor->featured;
        // $vendor->save();
        // return new VendorResource($vendor);
        return response()->json(['message' => 'Admin: Placeholder for toggling featured status for vendor ' . $vendor->id], 501);
    }
}
