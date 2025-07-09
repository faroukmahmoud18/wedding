<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'user_id', // The user who made the booking (can be null for guest bookings)
        'customer_name',
        'customer_email',
        'customer_phone',
        'booking_date', // Changed from event_date
        'time_slot',    // Optional
        'guests',       // Number of guests/participants
        'total_amount', // Changed from total
        'status',       // e.g., 'pending', 'confirmed', 'cancelled', 'completed', 'paid', 'unpaid'
        'payment_status',
        'transaction_id', // If integrating with a payment gateway
        'message',
        'cancellation_reason',
        'cancelled_by', // 'user', 'vendor', 'admin'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'datetime',
        'guests' => 'integer',
        'total_amount' => 'decimal:2',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['booking_date']; // Ensures booking_date is a Carbon instance

    /**
     * Get the service that was booked.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the user who made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Assumes User model exists
    }

    /**
     * Get the vendor for this booking through the service.
     */
    public function vendor()
    {
        // This returns the Vendor model instance directly via the service
        return $this->service ? $this->service->vendor : null;
    }

    /**
     * Accessor to get the vendor model instance directly.
     * Allows $booking->vendor_instance or similar if needed to avoid conflict with a potential vendor_id column.
     * For direct $booking->vendor access, ensure no 'vendor_id' column on bookings table or rename this.
     * Given no vendor_id on bookings, this accessor could be getVendorAttribute().
     */
    public function getVendorInstanceAttribute()
    {
        return $this->service ? $this->service->vendor : null;
    }

    // Optional: Scope for bookings with a certain status
    // public function scopeStatus(Builder $query, string $status): Builder
    // {
    //     return $query->where('status', $status);
    // }
}
