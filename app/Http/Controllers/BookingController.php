<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Assuming Booking and Service models will be created
// use App\Models\Booking;
// use App\Models\Service;

/**
 * BookingController is responsible for handling the creation and storage of new service bookings.
 */
class BookingController extends Controller
{
    /**
     * Store a newly created booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'event_date' => 'required|date|after_or_equal:today',
            'qty' => 'required|integer|min:1',
            'message' => 'nullable|string|max:1000',
        ]);

        $service = \App\Models\Service::findOrFail($validatedData['service_id']);

        // Basic total calculation - can be more complex based on service pricing model
        // This assumes price_from is the base price per unit.
        // A more robust system might have a dedicated pricing engine or method on the Service model.
        $total = ($service->price_from ?? 0) * $validatedData['qty'];
        if ($total == 0 && ($service->price_from || $service->price_to)) {
            // If price_from is set but total is 0, it implies "Contact for price" or complex pricing.
            // For now, we'll set total to 0 and vendor can update.
            // Or, prevent booking if price_from is null and no other pricing logic is in place.
            // For simplicity, let's allow booking with 0 total if price is not straightforward.
            $total = 0; // Vendor will confirm actual price
        }


        $booking = \App\Models\Booking::create([
            'service_id' => $validatedData['service_id'],
            'user_id' => auth()->id(), // Assumes user is logged in (add middleware to route)
            'event_date' => $validatedData['event_date'],
            'qty' => $validatedData['qty'],
            'total' => $total, // Placeholder total, vendor might confirm/adjust
            'status' => 'pending', // Default status
            'message' => $validatedData['message'] ?? null,
        ]);

        // TODO: Send notifications to user and vendor

        return redirect()->route('bookings.confirmation') // Assuming a named route for confirmation page
            ->with('booking_success_message', __('Your booking request has been submitted successfully! The vendor will contact you shortly.'))
            ->with('booking_id', $booking->id); // Pass booking ID to confirmation page
    }

    /**
     * Display booking confirmation page.
     * This method would typically be in a separate controller or handled differently,
     * but for simplicity, adding it here if routes point to it.
     * A better approach is a dedicated route that shows a generic message or fetches booking by ID from session.
     */
    public function confirmation()
    {
        // If booking_id is flashed to session, retrieve it.
        // $booking = Booking::find(session('booking_id'));
        // return view('bookings.confirmation', compact('booking'));
        if (session('booking_id')) {
            $booking = \App\Models\Booking::with('service')->find(session('booking_id'));
             return view('bookings.confirmation', compact('booking'));
        }
        // If no booking_id (e.g. direct access), show generic message or redirect.
        return view('bookings.confirmation');
    }
}
