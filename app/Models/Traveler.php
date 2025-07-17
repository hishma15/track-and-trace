<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traveler extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'national_id',
        'address',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function luggage()
    {
        return $this->hasMany(Luggage::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        return $this->user->full_name;
    }

}
