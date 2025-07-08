<?php

// routes/api.php (Additions / Examples)

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\VendorController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\API\Admin\ServiceController as AdminServiceController;
// Add AdminBookingController if you create one
use App\Http\Controllers\API\Vendor\ServiceController as VendorServiceController;
use App\Http\Controllers\API\Vendor\BookingController as VendorBookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// --- Authentication Routes ---
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// --- Publicly Accessible Service & Vendor Routes ---
Route::get('/services', [ServiceController::class, 'index'])->name('api.services.index');
// It's common to use a query parameter for category: /api/services?category=photography
// Route::get('/services/category/{categorySlug}', [ServiceController::class, 'getByCategory'])->name('api.services.category'); // If using path param
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('api.services.show'); // Uses route model binding for ID or slug

Route::get('/vendors', [VendorController::class, 'index'])->name('api.vendors.index');
Route::get('/vendors/{vendor}', [VendorController::class, 'show'])->name('api.vendors.show'); // Route model binding
// Route::get('/vendors/{vendor}/services', [VendorController::class, 'services'])->name('api.vendors.services'); // If using this specific endpoint

// --- Protected Routes (require authentication) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/user', [AuthController::class, 'user'])->name('api.user');

    // Bookings (for authenticated users)
    Route::post('/bookings', [BookingController::class, 'store'])->name('api.bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('api.bookings.index'); // User's own bookings
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('api.bookings.show'); // Add policy for ownership
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('api.bookings.update'); // Add policy

    // --- Vendor Specific Routes ---
    // Prefix with 'vendor' and add vendor role middleware
    Route::prefix('vendor')->name('api.vendor.')->middleware(['auth:sanctum', /* 'role:vendor' */])->group(function () {
        Route::get('/services', [VendorServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [VendorServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}', [VendorServiceController::class, 'show'])->name('services.show'); // Ensure service belongs to vendor
        Route::put('/services/{service}', [VendorServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [VendorServiceController::class, 'destroy'])->name('services.destroy');

        Route::get('/bookings', [VendorBookingController::class, 'index'])->name('bookings.index'); // Bookings for this vendor's services
        Route::get('/bookings/{booking}', [VendorBookingController::class, 'show'])->name('bookings.show');
        Route::put('/bookings/{booking}', [VendorBookingController::class, 'update'])->name('bookings.update'); // e.g., confirm/cancel
    });

    // --- Admin Specific Routes ---
    // Prefix with 'admin' and add admin role middleware
    Route::prefix('admin')->name('api.admin.')->middleware(['auth:sanctum', /* 'role:admin' */])->group(function () {
        Route::get('/vendors', [AdminVendorController::class, 'index'])->name('vendors.index');
        Route::post('/vendors', [AdminVendorController::class, 'store'])->name('vendors.store');
        Route::get('/vendors/{vendor}', [AdminVendorController::class, 'show'])->name('vendors.show');
        Route::put('/vendors/{vendor}', [AdminVendorController::class, 'update'])->name('vendors.update');
        Route::delete('/vendors/{vendor}', [AdminVendorController::class, 'destroy'])->name('vendors.destroy');
        Route::patch('/vendors/{vendor}/toggle-verification', [AdminVendorController::class, 'toggleVerification'])->name('vendors.toggleVerification');
        Route::patch('/vendors/{vendor}/toggle-featured', [AdminVendorController::class, 'toggleFeatured'])->name('vendors.toggleFeatured');

        Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
        Route::get('/services/{service}', [AdminServiceController::class, 'show'])->name('services.show');
        Route::put('/services/{service}', [AdminServiceController::class, 'update'])->name('services.update'); // For admin edits
        Route::patch('/services/{service}/toggle-active', [AdminServiceController::class, 'toggleActive'])->name('services.toggleActive');
        Route::patch('/services/{service}/toggle-featured', [AdminServiceController::class, 'toggleFeatured'])->name('services.toggleFeatured');
        Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

        // Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index'); // All site bookings
        // Route::get('/users', [AdminUserController::class, 'index'])->name('users.index'); // Manage users
    });
});

// Fallback route for API if needed, though typically handled by frontend router for SPAs
// Route::fallback(function(){
//     return response()->json(['message' => 'API Not Found.'], 404);
// });
?>
