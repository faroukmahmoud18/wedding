<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceMeta extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'meta_key',
        'meta_value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'meta_value' => 'json', // If meta_value can store complex data like arrays or objects
    ];

    /**
     * Indicates if the model should be timestamped.
     * Service meta might not need timestamps if it's purely descriptive and versioning isn't critical.
     * Set to true if you need created_at and updated_at.
     *
     * @var bool
     */
    public $timestamps = false; // As per common practice for meta tables, adjust if needed

    /**
     * Get the service that this metadata belongs to.
     * This defines an inverse one-to-many relationship.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
