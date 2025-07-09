<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage; // For logo URL

class Vendor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vendors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'contact_email',
        'phone_number',
        'logo_path',
        'description',
        'address',
        'city',
        'country',
        'is_approved',
        'is_suspended',
        'suspension_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'is_suspended' => 'boolean',
        // 'address' => 'array', // Example if address is stored as JSON (e.g., for structured address)
    ];

    /**
     * Get the services offered by the vendor.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the user account that this vendor profile might be directly associated with.
     * This relationship assumes a User record (with role 'vendor') has a vendor_id pointing here,
     * making User the owner of this Vendor profile.
     * Or, if a Vendor is managed by a User, then this Vendor has a user_id.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id'); // Assumes vendors.user_id foreign key
    }

    /**
     * Scope a query to only include approved and not suspended vendors.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true)->where('is_suspended', false);
    }

    /**
     * Scope a query to only include active (approved and not suspended) vendors.
     * Alias for scopeApproved.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $this->scopeApproved($query);
    }

    /**
     * Get the URL for the vendor's logo.
     * Accessor: getLogoUrlAttribute
     *
     * @return string|null
     */
    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            return Storage::disk('public')->url($this->logo_path);
        }
        // Return a default placeholder if no logo or logo not found
        // Consider a more thematically appropriate placeholder
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=795548&background=E1C699'; // Theme colors
    }

    /**
     * Scope a query to only include suspended vendors.
     */
    public function scopeSuspended(Builder $query): Builder
    {
        return $query->where('is_suspended', true);
    }
}
