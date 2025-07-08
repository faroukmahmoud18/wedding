<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // Required for scope

class Service extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vendor_id',
        'category',
        'title',
        'slug',
        'short_desc',
        'long_desc',
        'price_from',
        'price_to',
        'unit', // e.g., 'per hour', 'per event', 'per person'
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price_from' => 'decimal:2', // Example: casts to a float with 2 decimal places
        'price_to' => 'decimal:2',
    ];

    /**
     * Get the vendor that offers this service.
     * This defines an inverse one-to-many relationship (belongs to).
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the images for the service.
     * This defines a one-to-many relationship.
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the metadata for the service.
     * This defines a one-to-many relationship.
     */
    public function serviceMeta()
    {
        return $this->hasMany(ServiceMeta::class);
    }

    /**
     * Get the bookings for the service.
     * This defines a one-to-many relationship.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for the service.
     * This defines a one-to-many relationship.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Scope a query to only include active services.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the route key for the model.
     * Allows using 'slug' for route model binding instead of 'id'.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
