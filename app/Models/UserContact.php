<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country_id',
        'state_id',
        'city_id',
        'phone',
        'instagram',
        'tiktok',
        'x_handle',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(\Altwaireb\World\Models\Country::class);
    }

    public function state()
    {
        return $this->belongsTo(\Altwaireb\World\Models\State::class);
    }

    public function city()
    {
        return $this->belongsTo(\Altwaireb\World\Models\City::class);
    }
}
