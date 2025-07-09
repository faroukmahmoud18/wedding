<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * HomeController handles routes related to general site pages like the homepage and admin dashboard.
 */
class HomeController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch a few approved, active services (e.g., latest or featured)
        $featuredServices = \App\Models\Service::with('vendor', 'images')
            ->live() // Uses the scopeLive() in Service model
            ->orderBy('created_at', 'desc') // Example: latest services
            ->take(4)
            ->get();

        // Fetch a few approved, active vendors (e.g., by rating or latest)
        $featuredVendors = \App\Models\Vendor::with('services')
            ->active() // Uses the scopeActive() in Vendor model
            ->orderBy('created_at', 'desc') // Example: latest vendors
            ->take(4)
            ->get();

        // Fetch categories - this could come from a dedicated categories table or distinct values from services
        $categories = \App\Models\Service::live()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->take(6) // Limit number of categories shown on homepage
            ->pluck('category');


        return view('home', compact('featuredServices', 'featuredVendors', 'categories'));
    }

    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {
        // Logic to display admin dashboard
        // Example: return view('admin.dashboard');
        return view('admin.dashboard'); // Assuming admin/dashboard.blade.php
    }
}
