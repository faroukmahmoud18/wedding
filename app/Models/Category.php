<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id', // For hierarchical categories (optional)
        'image_path', // For category image (optional)
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = []; // Add casts if needed, e.g., for JSON fields

    /**
     * Boot method to automatically generate slug from name if not provided.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
                // Ensure slug uniqueness (simple version)
                $originalSlug = $category->slug;
                $count = 1;
                while (static::where('slug', $category->slug)->exists()) {
                    $category->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });

        static::updating(function ($category) {
            // If name changes and slug is meant to auto-update (or was empty)
            if ($category->isDirty('name') && (empty($category->getOriginal('slug')) || $category->slug === Str::slug($category->getOriginal('name'))) ) {
                 $category->slug = Str::slug($category->name);
                $originalSlug = $category->slug;
                $count = 1;
                // Ensure slug uniqueness on update, excluding self
                while (static::where('id', '!=', $category->id)->where('slug', $category->slug)->exists()) {
                    $category->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });
    }

    /**
     * Get the services associated with the category.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the parent category (if hierarchical).
     */
    // public function parent(): BelongsTo
    // {
    //     return $this->belongsTo(Category::class, 'parent_id');
    // }

    /**
     * Get the child categories (if hierarchical).
     */
    // public function children(): HasMany
    // {
    //     return $this->hasMany(Category::class, 'parent_id');
    // }

    /**
     * Get the URL for the category's image.
     * Accessor: getImageUrlAttribute
     */
    // public function getImageUrlAttribute(): ?string
    // {
    //     if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
    //         return Storage::disk('public')->url($this->image_path);
    //     }
    //     return null; // Or a default placeholder
    // }

    /**
     * Get the route key for the model.
     * Allows using 'slug' for route model binding instead of 'id'.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
