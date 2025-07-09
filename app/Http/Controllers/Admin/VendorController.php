<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\User; // If creating a user for the vendor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // If creating user password
use Illuminate\Support\Str;

class VendorController extends Controller
{
    /**
     * Display a listing of the vendors.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Vendor::with('user')->orderBy('created_at', 'desc');

        // Filtering
        if ($request->filled('status')) {
            match ($request->status) {
                'approved' => $query->approved(),
                'pending' => $query->where('is_approved', false)->whereNull('is_suspended'),
                'suspended' => $query->suspended(),
                default => null,
            };
        }
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                  ->orWhere('contact_email', 'LIKE', $searchTerm)
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('email', 'LIKE', $searchTerm);
                  });
            });
        }

        $vendors = $query->paginate(15)->appends($request->query());
        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new vendor.
     * (Admin might create vendors directly in some systems)
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.vendors.create');
    }

    /**
     * Store a newly created vendor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedUserData = $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validatedVendorData = $request->validate([
            'vendor_name' => 'required|string|max:255|unique:vendors,name',
            'contact_email' => 'required|string|email|max:255|unique:vendors,contact_email',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_approved' => 'sometimes|boolean',
        ]);

        $user = User::create([
            'name' => $validatedUserData['user_name'],
            'email' => $validatedUserData['email'],
            'password' => Hash::make($validatedUserData['password']),
            'role' => 'vendor', // Assign vendor role
        ]);

        $vendor = new Vendor($validatedVendorData);
        $vendor->name = $validatedVendorData['vendor_name']; // Ensure 'name' is set if different from 'vendor_name' field
        $vendor->user_id = $user->id;
        $vendor->is_approved = $request->has('is_approved') ? (bool)$request->is_approved : false;
        // $vendor->slug = Str::slug($validatedVendorData['vendor_name']); // Handled by mutator/observer potentially

        if ($request->hasFile('logo')) {
            $vendor->logo_path = $request->file('logo')->store('vendors/logos', 'public');
        }
        $vendor->save();

        return redirect()->route('admin.vendors.index')->with('success', __('Vendor created successfully.'));
    }


    /**
     * Display the specified vendor.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\View\View
     */
    public function show(Vendor $vendor)
    {
        $vendor->load('user', 'services', 'services.bookings'); // Load related data
        return view('admin.vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified vendor.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\View\View
     */
    public function edit(Vendor $vendor)
    {
        $vendor->load('user');
        return view('admin.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified vendor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validatedVendorData = $request->validate([
            'name' => 'required|string|max:255|unique:vendors,name,' . $vendor->id,
            'contact_email' => 'required|string|email|max:255|unique:vendors,contact_email,' . $vendor->id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_approved' => 'sometimes|boolean',
            'is_suspended' => 'sometimes|boolean',
            'suspension_reason' => 'nullable|string|max:1000|required_if:is_suspended,true',
        ]);

        $vendor->fill($validatedVendorData);
        $vendor->is_approved = $request->has('is_approved');
        $vendor->is_suspended = $request->has('is_suspended');
        if (!$vendor->is_suspended) {
            $vendor->suspension_reason = null;
        }


        if ($request->hasFile('logo')) {
            // Consider deleting old logo
            // if ($vendor->logo_path) Storage::disk('public')->delete($vendor->logo_path);
            $vendor->logo_path = $request->file('logo')->store('vendors/logos', 'public');
        }
        $vendor->save();

        // Update associated user details if provided
        if ($request->filled('user_name') || $request->filled('email')) {
            $validatedUserData = $request->validate([
                'user_name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $vendor->user_id,
            ]);
            if ($vendor->user) {
                $updateData = [];
                if(!empty($validatedUserData['user_name'])) $updateData['name'] = $validatedUserData['user_name'];
                if(!empty($validatedUserData['email'])) $updateData['email'] = $validatedUserData['email'];
                if(!empty($updateData)) $vendor->user->update($updateData);
            }
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            if($vendor->user) {
                $vendor->user->update(['password' => Hash::make($request->password)]);
            }
        }


        return redirect()->route('admin.vendors.index')->with('success', __('Vendor updated successfully.'));
    }

    /**
     * Remove the specified vendor from storage.
     * (Soft delete is often preferred for vendors)
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Vendor $vendor)
    {
        // Before deleting a vendor, consider implications:
        // - What happens to their services, bookings, user account?
        // - Soft delete is generally safer.
        // If User model has a foreign key constraint for vendor_id, it might prevent deletion
        // or cascade delete the user, which might not be desired.

        // Example: just mark as suspended or add a 'deleted_at' if using soft deletes.
        // For now, a hard delete for simplicity of example, but this needs careful consideration.
        // $vendor->user()->delete(); // If the user associated should also be deleted.
        $vendor->delete();

        return redirect()->route('admin.vendors.index')->with('success', __('Vendor deleted successfully.'));
    }

    /**
     * Approve a pending vendor.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Vendor $vendor)
    {
        $vendor->is_approved = true;
        $vendor->is_suspended = false; // Ensure not suspended when approving
        $vendor->suspension_reason = null;
        $vendor->save();

        // Optionally, send a notification to the vendor
        // Mail::to($vendor->user->email)->send(new VendorApproved($vendor));

        return redirect()->route('admin.vendors.index')->with('success', __('Vendor approved successfully.'));
    }

    /**
     * Suspend an active vendor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suspend(Request $request, Vendor $vendor)
    {
        $request->validate(['suspension_reason' => 'required_if:is_suspended,true|string|max:1000']);

        $vendor->is_suspended = true;
        $vendor->suspension_reason = $request->suspension_reason;
        // $vendor->is_approved = false; // Optional: also mark as unapproved
        $vendor->save();

        // Optionally, send a notification to the vendor
        // Mail::to($vendor->user->email)->send(new VendorSuspended($vendor, $request->suspension_reason));

        return redirect()->route('admin.vendors.index')->with('success', __('Vendor suspended successfully.'));
    }

    /**
     * Unsuspend a vendor.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsuspend(Vendor $vendor)
    {
        $vendor->is_suspended = false;
        $vendor->suspension_reason = null;
        $vendor->save();
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor unsuspended successfully.');
    }
}
