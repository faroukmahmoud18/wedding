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

        // Fetch categories - now fetching actual Category models
        // We can get categories that actually have live services.
        $categoryIdsWithLiveServices = \App\Models\Service::live()
            ->select('category_id')
            ->distinct()
            ->pluck('category_id');

        $categories = \App\Models\Category::whereIn('id', $categoryIdsWithLiveServices)
            ->orderBy('name')
            ->take(6) // Limit number of categories shown on homepage
            ->get();


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
