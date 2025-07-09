<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Booking;

class DashboardController extends Controller
{
    /**
     * Display the vendor dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $vendor = Auth::user()->vendor; // Assuming a user has one vendor profile linked

        if (!$vendor) {
            // This case should ideally be handled by middleware (e.g., redirect if not a vendor)
            // Or, if vendors need to complete a profile first.
            return redirect()->route('home')->with('error', __('Vendor profile not found or not accessible.'));
        }

        // Eager load services with their bookings count for efficiency if needed often
        $vendor->loadCount([
            'services',
            'services as live_services_count' => function ($query) {
                $query->live();
            },
            'services as pending_services_count' => function ($query) {
                $query->where('status', 'pending_approval');
            }
        ]);

        // Fetch recent bookings for this vendor's services
        $recentBookings = Booking::whereHas('service', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })
        ->with(['service', 'user']) // Eager load related service and user (customer)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        $totalBookingsCount = Booking::whereHas('service', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })->count();

        // Example: Calculate earnings (simplified, assumes bookings have a 'price' or 'total_amount' field)
        // $totalEarnings = Booking::whereHas('service', function ($query) use ($vendor) {
        //     $query->where('vendor_id', $vendor->id);
        // })->where('status', 'confirmed')->sum('total_amount'); // Make sure 'total_amount' exists on Booking model

        $stats = [
            'total_services' => $vendor->services_count,
            'live_services' => $vendor->live_services_count,
            'pending_services' => $vendor->pending_services_count,
            'total_bookings' => $totalBookingsCount,
            // 'total_earnings' => $totalEarnings ?? 0, // Uncomment and adapt if earnings are tracked
            // Add more stats: e.g., average rating across services
        ];

        $recentServices = $vendor->services()->orderBy('updated_at', 'desc')->take(5)->get();


        return view('vendor.dashboard', compact('vendor', 'stats', 'recentBookings', 'recentServices'));
    }
}
