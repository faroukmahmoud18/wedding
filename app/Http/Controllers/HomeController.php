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
        // Logic to display homepage
        // Example: return view('welcome');
        return view('home'); // Assuming you have a home.blade.php or similar
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
