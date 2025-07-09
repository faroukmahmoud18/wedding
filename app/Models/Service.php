<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // Required for scope
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage; // For image URL
use Illuminate\Support\Str; // For slug generation

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
        'category_id', // Changed from 'category'
        'title',
        'slug',
        'short_desc',
        'description', // Changed from 'long_desc'
        'price',       // Changed from 'price_from', removed 'price_to'
        'price_unit',  // Changed from 'unit'
        'is_live',     // Changed from 'is_active'
        'location_text',
        'tags',
        'status',      // e.g., 'pending_approval', 'approved', 'rejected', 'on_hold'
        'rejection_reason',
        'featured_image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_live' => 'boolean',
        'price' => 'decimal:2',
        'tags' => 'array',
    ];

    /**
     * Boot method to automatically generate slug from title if not provided.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
                // Ensure slug uniqueness
                $originalSlug = $service->slug;
                $count = 1;
                while (static::where('slug', $service->slug)->exists()) {
                    $service->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('title') && empty($service->slug)) { // Or if you allow slug regeneration
                 $service->slug = Str::slug($service->title);
                $originalSlug = $service->slug;
                $count = 1;
                while (static::where('id', '!=', $service->id)->where('slug', $service->slug)->exists()) {
                    $service->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });
    }

    /**
     * Get the vendor that offers this service.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the category for the service.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the images for the service.
     * Assuming a ServiceImage model for additional images.
     * If only one featured image, this might not be needed or structured differently.
     */
    public function images(): HasMany
    {
        // If you have a dedicated ServiceImage model:
        // return $this->hasMany(ServiceImage::class);
        // If using a generic Image model with polymorphic relations or simple FK:
        return $this->hasMany(Image::class); // Keep as is if Image model is generic for now
    }

    /**
     * Get the bookings for the service.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for the service.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Scope a query to only include services that are truly "live" and viewable by public.
     * (Vendor marked active, Admin approved status)
     */
    public function scopeLive(Builder $query): Builder
    {
        return $query->where('is_live', true)->where('status', 'approved');
    }

    /**
     * Scope a query to only include services that are approved.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include services that are pending admin approval.
     */
    public function scopePendingApproval(Builder $query): Builder
    {
        return $query->where('status', 'pending_approval');
    }


    /**
     * Get the route key for the model.
     * Allows using 'slug' for route model binding instead of 'id'.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the URL of the first/featured image for the service.
     * Accessor: getFeaturedImageUrlAttribute
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image_path && Storage::disk('public')->exists($this->featured_image_path)) {
            return Storage::disk('public')->url($this->featured_image_path);
        }
        // Fallback placeholder using theme colors
        return 'https://ui-avatars.com/api/?name=' . urlencode(Str::limit($this->title, 2, '')) . '&size=300x200&color=FFFFFF&background=E1C699&bold=true&format=png&font-size=0.33&text=' . urlencode($this->title);
    }

    /**
     * Get category name for display.
     * Accessor: getCategoryNameAttribute
     */
    public function getCategoryNameAttribute(): string
    {
        return $this->category->name ?? __('N/A');
    }

    /**
     * Calculate the average rating for the service.
     *
     * @return float
     */
    public function averageRating(): float
    {
        return $this->reviews()->approved()->average('rating') ?? 0.0;
    }

    /**
     * Get the average rating attribute.
     * Accessor: getAverageRatingAttribute
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->averageRating();
    }
}
