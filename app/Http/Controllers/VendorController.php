<?php

namespace App\Http\Controllers;

use App\Models\Vendor; // Assuming Vendor model will be created
use Illuminate\Http\Request;

/**
 * VendorController handles the display of public vendor profiles, vendor-specific dashboards (for logged-in vendors),
 * and administrative CRUD operations for managing vendors (typically by an admin).
 */
class VendorController extends Controller
{
    /**
     * Display a listing of the resource for admin.
     * (Admin CRUD for vendors)
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Logic for admin to view all vendors
        // Example: $vendors = Vendor::latest()->paginate(10);
        // return view('admin.vendors.index', compact('vendors'));
        return view('admin.vendors.index');
    }

    /**
     * Display the public profile of a vendor.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function publicProfile($id)
    {
        $vendor = Vendor::with(['services' => function ($query) {
            $query->live()->orderBy('created_at', 'desc'); // Only live services, latest first
        }])
        ->active() // Vendor themselves must be active/approved
        ->findOrFail($id);

        // You might want to paginate services if a vendor has many
        // For now, fetching all live services. If pagination is needed:
        // $services = $vendor->services()->live()->paginate(10);
        // return view('vendors.profile', compact('vendor', 'services'));

        return view('vendors.profile', compact('vendor'));
    }

    /**
     * Display the vendor dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Logic for vendor's own dashboard
        // Example: $vendor = auth()->user()->vendor; // Assuming user is associated with a vendor
        // return view('vendor.dashboard', compact('vendor'));
        return view('vendor.dashboard');
    }

    /**
     * Show the form for creating a new resource for admin.
     * (Admin CRUD for vendors)
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Logic for admin to show vendor creation form
        // return view('admin.vendors.create');
        return view('admin.vendors.create');
    }

    /**
     * Store a newly created resource in storage by admin.
     * (Admin CRUD for vendors)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Logic for admin to store a new vendor
        // Example: $validatedData = $request->validate([...]);
        // Vendor::create($validatedData);
        // return redirect()->route('admin.vendors.index')->with('success', __('Vendor created successfully.'));
        return redirect()->route('admin.vendors.index');
    }

    /**
     * Show the form for editing the specified resource by admin.
     * (Admin CRUD for vendors)
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Logic for admin to show vendor edit form
        // Example: $vendor = Vendor::findOrFail($id);
        // return view('admin.vendors.edit', compact('vendor'));
        return view('admin.vendors.edit', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage by admin.
     * (Admin CRUD for vendors)
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Logic for admin to update a vendor
        // Example: $validatedData = $request->validate([...]);
        // $vendor = Vendor::findOrFail($id);
        // $vendor->update($validatedData);
        // return redirect()->route('admin.vendors.index')->with('success', __('Vendor updated successfully.'));
        return redirect()->route('admin.vendors.index');
    }

    /**
     * Remove the specified resource from storage by admin.
     * (Admin CRUD for vendors)
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Logic for admin to delete a vendor
        // Example: $vendor = Vendor::findOrFail($id);
        // $vendor->delete(); // Consider soft deletes or handling related services
        // return redirect()->route('admin.vendors.index')->with('success', __('Vendor deleted successfully.'));
        return redirect()->route('admin.vendors.index');
    }
}
