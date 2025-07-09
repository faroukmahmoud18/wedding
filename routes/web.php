<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VendorController;

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
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () { // Added auth and verified middleware
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard');

    // Vendor CRUD
    Route::resource('vendors', VendorController::class)->except(['show']);

    // Service CRUD (admin oversight)
    Route::resource('services', ServiceController::class)->except(['show', 'category', 'index']); // index is covered by category
});

// Vendor Dashboard
Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'verified'])->group(function () { // Added auth and verified middleware
    Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard'); // Vendor specific dashboard

    // Services CRUD for vendors (managing their own services)
    // Assuming a vendor can only manage their own services, policy/auth checks will be needed in the controller.
    Route::resource('services', ServiceController::class)->names([
        'index' => 'services.index',
        'create' => 'services.create',
        'store' => 'services.store',
        'edit' => 'services.edit',
        'update' => 'services.update',
        'destroy' => 'services.destroy',
    ])->except(['show', 'category']); // 'show' is public, 'category' is a general listing
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
