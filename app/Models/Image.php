<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'path',
        'alt', // Alt text for accessibility and SEO
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // No specific casts needed for these fields by default
    ];

    /**
     * Indicates if the model should be timestamped.
     * Image records might not need timestamps if they are simple references.
     * Set to true if you want to track when image records were created/updated.
     *
     * @var bool
     */
    public $timestamps = true; // Or false, depending on requirements

    /**
     * Get the service that this image belongs to.
     * This defines an inverse one-to-many relationship.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
