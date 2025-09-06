<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'traveler_id',
        'subject',
        'message',
        'status',
        'admin_response',
        'submitted_at',
        'responded_at',
        'rating',
    ];

    protected $casts = [
    'submitted_at' => 'datetime',
    'responded_at' => 'datetime',
];

    // Relationships
    public function traveler()
    {
        return $this->belongsTo(Traveler::class);
    }

    // Helper methods
    
}
