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
        'category',
        'title',
        'slug',
        'short_desc',
        'long_desc',
        'price_from',
        'price_to',
        'unit',
        'is_active', // Vendor/Admin can toggle this
        'location_text',
        'tags', // Stored as JSON array
        'status', // 'draft', 'pending_approval', 'approved', 'rejected', 'inactive'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price_from' => 'decimal:2',
        'price_to' => 'decimal:2',
        'tags' => 'array', // Cast JSON 'tags' to array
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
     * Get the images for the service.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the metadata for the service.
     */
    public function serviceMeta(): HasMany
    {
        return $this->hasMany(ServiceMeta::class);
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
        return $query->where('is_active', true)->where('status', 'approved');
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
        $firstImage = $this->images()->first();
        if ($firstImage && $firstImage->path && Storage::disk('public')->exists($firstImage->path)) {
            return Storage::disk('public')->url($firstImage->path);
        }
        // Fallback placeholder
        return 'https://via.placeholder.com/300x200.png?text=' . urlencode($this->title);
    }

    /**
     * Get category name for display.
     * Accessor: getCategoryNameAttribute
     */
    public function getCategoryNameAttribute(): string
    {
        return Str::title(str_replace('_', ' ', $this->category));
    }
}
