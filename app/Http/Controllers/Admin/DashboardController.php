<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch some basic stats for the dashboard
        $stats = [
            'total_users' => User::count(),
            'total_vendors' => Vendor::count(),
            'pending_vendors' => Vendor::where('is_approved', false)->whereNull('is_suspended')->count(),
            'total_services' => Service::count(),
            'pending_services' => Service::where('status', 'pending_approval')->count(),
            'total_bookings' => Booking::count(),
            // Add more stats as needed: e.g., total revenue (if applicable), recent activities
        ];

        // Fetch recent pending vendors or services for quick review (optional)
        $recentPendingVendors = Vendor::where('is_approved', false)
                                      ->whereNull('is_suspended')
                                      ->orderBy('created_at', 'desc')
                                      ->take(5)
                                      ->get();

        $recentPendingServices = Service::where('status', 'pending_approval')
                                       ->orderBy('created_at', 'desc')
                                       ->take(5)
                                       ->get();

        return view('admin.dashboard', compact('stats', 'recentPendingVendors', 'recentPendingServices'));
    }
}
