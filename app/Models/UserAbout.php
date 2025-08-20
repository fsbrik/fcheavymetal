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
        'investment_capacity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
