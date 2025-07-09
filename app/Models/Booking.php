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
        'user_id', // The user who made the booking
        'event_date',
        'qty', // Quantity or number of units (e.g., hours, guests)
        'total', // Total price for the booking
        'status', // e.g., 'pending', 'confirmed', 'cancelled', 'completed'
        'message', // Optional message from user during booking
        // You might add vendor_id here if you want a direct link,
        // though it can be derived via service->vendor
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'datetime',
        'qty' => 'integer',
        'total' => 'decimal:2',
    ];

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

    // Optional: Scope for bookings with a certain status
    // public function scopeStatus(Builder $query, string $status): Builder
    // {
    //     return $query->where('status', $status);
    // }
}
