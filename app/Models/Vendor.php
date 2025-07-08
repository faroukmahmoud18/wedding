<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'logo',
        'about',
        'phone',
        'email',
        'address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'address' => 'array', // If address is stored as JSON
    ];

    /**
     * Get the services offered by the vendor.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Optional: If vendors are linked to a user account
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
