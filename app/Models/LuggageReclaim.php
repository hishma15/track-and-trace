<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuggageReclaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'luggage_id',
        'traveler_id',
        'user_id',              // ✅ changed from staff_id
        'collector_name',
        'collector_id_type',
        'collector_id_number',
        'collector_contact',
        'relationship',
        'otp_code',
        'otp_verified',
        'reclaimed_at',
    ];

    // 🔗 Relationships
    public function luggage()
    {
        return $this->belongsTo(Luggage::class);
    }

    public function traveler()
    {
        return $this->belongsTo(Traveler::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // ✅ staff who handled reclaim
    }
}
