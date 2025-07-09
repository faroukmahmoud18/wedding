<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    private function getVendor() {
        $vendor = Auth::user()->vendor;
        if (!$vendor) {
            abort(403, 'User is not a vendor or vendor profile not found.');
        }
        return $vendor;
    }

    /**
     * Display a listing of bookings for the vendor's services.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $vendor = $this->getVendor();

        $bookingsQuery = Booking::whereHas('service', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })->with(['service', 'user'])->orderBy('created_at', 'desc');

        // Filtering
        if ($request->filled('service_id')) {
            $bookingsQuery->where('service_id', $request->service_id);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $bookingsQuery->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $bookingsQuery->whereDate('booking_date', '>=', $request->date_from); // Assumes 'booking_date' field
        }
        if ($request->filled('date_to')) {
            $bookingsQuery->whereDate('booking_date', '<=', $request->date_to);
        }


        $bookings = $bookingsQuery->paginate(15)->appends($request->query());
        $services = $vendor->services()->orderBy('title')->get(); // For filter dropdown

        return view('vendor.bookings.index', compact('bookings', 'vendor', 'services'));
    }

    /**
     * Display the specified booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\View\View
     */
    public function show(Booking $booking)
    {
        $vendor = $this->getVendor();
        // Ensure the booking belongs to a service owned by the authenticated vendor
        if ($booking->service->vendor_id !== $vendor->id) {
            abort(403, 'You do not have permission to view this booking.');
        }

        $booking->load(['service', 'user', 'transactions']); // Eager load details
        return view('vendor.bookings.show', compact('booking', 'vendor'));
    }

    /**
     * Update the status of a booking (e.g., confirm, cancel).
     * Vendors might have limited ability to change status compared to admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $vendor = $this->getVendor();
        if ($booking->service->vendor_id !== $vendor->id) {
            abort(403, 'Action not allowed.');
        }

        $validated = $request->validate([
            'status' => ['required', \Illuminate\Validation\Rule::in(['confirmed', 'cancelled', 'completed'])], // Vendor allowed statuses
            'cancellation_reason_vendor' => 'nullable|string|max:500|required_if:status,cancelled',
        ]);

        // Business logic for status changes
        // Example: Cannot confirm an already cancelled booking, etc.
        if ($booking->status === 'cancelled' && $validated['status'] !== 'cancelled') {
             return redirect()->back()->with('error', __('Cannot change status of a cancelled booking.'));
        }
        // if ($booking->status === 'completed' && $validated['status'] !== 'completed') {
        //      return redirect()->back()->with('error', __('Cannot change status of a completed booking.'));
        // }


        $booking->status = $validated['status'];
        if ($validated['status'] === 'cancelled') {
            $booking->cancellation_reason = $validated['cancellation_reason_vendor'] ?? $booking->cancellation_reason; // Keep original if user cancelled
            $booking->cancelled_by = 'vendor';
        } else {
            // Clear cancellation details if changing from cancelled to something else (if allowed by logic)
            // $booking->cancellation_reason = null;
            // $booking->cancelled_by = null;
        }

        // If marking as completed, perhaps additional logic (e.g., payment processing, review prompts)
        if ($validated['status'] === 'completed') {
            // Trigger events or notifications
        }


        $booking->save();

        // Notify customer?
        // Mail::to($booking->user->email)->send(new BookingStatusUpdated($booking));


        return redirect()->route('vendor.bookings.show', $booking)->with('success', __('Booking status updated successfully.'));
    }
}
