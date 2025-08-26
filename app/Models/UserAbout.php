<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAbout extends Model
{
    use HasFactory;

    protected $table = 'user_about'; 
    
    protected $fillable = [
        'user_id',
        'music_styles',   
        'religion', 
        'education_level',
        'professions',      
        'investment_capacity',
    ];

    protected $casts = [
        'music_styles' => 'array',
        'professions' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
