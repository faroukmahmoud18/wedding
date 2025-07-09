<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SearchController; // Added SearchController
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Service category listing
Route::get('/services/category/{category}', [ServiceController::class, 'category'])->name('services.category');

// Individual service detail
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Vendor public profile
Route::get('/vendors/{id}', [VendorController::class, 'publicProfile'])->name('vendors.profile');

// Booking submission
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/booking/confirmation', [BookingController::class, 'confirmation'])->name('bookings.confirmation');

// Admin Dashboard
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified']) // Added 'admin' middleware
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Vendor Management
        Route::resource('vendors', App\Http\Controllers\Admin\VendorController::class);
        Route::patch('vendors/{vendor}/approve', [App\Http\Controllers\Admin\VendorController::class, 'approve'])->name('vendors.approve');
        Route::patch('vendors/{vendor}/suspend', [App\Http\Controllers\Admin\VendorController::class, 'suspend'])->name('vendors.suspend');
        Route::patch('vendors/{vendor}/unsuspend', [App\Http\Controllers\Admin\VendorController::class, 'unsuspend'])->name('vendors.unsuspend');


        // Service Management
        Route::resource('services', App\Http\Controllers\Admin\ServiceController::class)->except(['create', 'store']); // Admin edits, not creates from scratch typically
        Route::patch('services/{service}/approve', [App\Http\Controllers\Admin\ServiceController::class, 'approve'])->name('services.approve');
        Route::patch('services/{service}/reject', [App\Http\Controllers\Admin\ServiceController::class, 'reject'])->name('services.reject');
        Route::patch('services/{service}/toggle-live', [App\Http\Controllers\Admin\ServiceController::class, 'toggleLive'])->name('services.toggleLive');

        // Category Management
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

        // Potentially other admin routes: Bookings, Reviews, Settings etc.
        // Route::get('bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
        // Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'edit', 'update', 'destroy']);
});

// Vendor Dashboard
Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'verified', 'vendor']) // Ensure 'vendor' middleware exists
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Vendor\DashboardController::class, 'index'])->name('dashboard');

        // Vendor's own Service Management
        Route::resource('services', App\Http\Controllers\Vendor\ServiceController::class);
        // Add any custom actions for vendor services if needed, e.g., duplicate, unpublish (distinct from admin's is_live)
        // Route::post('services/{service}/duplicate', [App\Http\Controllers\Vendor\ServiceController::class, 'duplicate'])->name('services.duplicate');

        // Vendor's Booking Management
        Route::get('bookings', [App\Http\Controllers\Vendor\BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [App\Http\Controllers\Vendor\BookingController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}/status', [App\Http\Controllers\Vendor\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

        // Vendor Profile Management (Example, if not handled by a generic user profile system)
        // Route::get('profile', [App\Http\Controllers\Vendor\ProfileController::class, 'edit'])->name('profile.edit');
        // Route::put('profile', [App\Http\Controllers\Vendor\ProfileController::class, 'update'])->name('profile.update');
});

// Auth routes - keep them if you are using Laravel Breeze/Jetstream for auth scaffolding
// If not, you'll need to define login, register, etc. routes manually or via a package.
// For simplicity, assuming auth routes are handled by Laravel's built-in or a starter kit.
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// Example of a fallback route for settings if it was intended to be kept
if (file_exists(__DIR__.'/settings.php')) {
    // Ensure this does not conflict with admin/vendor settings if any
    // Route::middleware(['auth', 'verified'])->group(function () {
    // require __DIR__.'/settings.php';
    // });
}

// A catch-all route for basic welcome/info, if needed, and not using Inertia
// Route::get('/welcome', function () {
//     return view('welcome'); // Make sure you have a welcome.blade.php
// })->name('welcome');

// Remove default dashboard route if it uses Inertia and you're not using it
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('dashboard', function () {
//         // return Inertia::render('dashboard'); // This was the Inertia line
//         return view('dashboard'); // Change to a Blade view if you have one
//     })->name('dashboard'); // This might conflict with admin.dashboard or vendor.dashboard
// });
// It's better to define specific dashboard routes as done above (admin.dashboard, vendor.dashboard)

?>
