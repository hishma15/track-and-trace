<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'luggage_id',
        'notification_type',
        'title',
        'message',
        'data',
        'is_read',
        'is_email_sent',
        'sent_date',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'is_read' => 'boolean',
            'is_email_sent' => 'boolean',
            'sent_date' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function luggage()
    {
        return $this->belongsTo(Luggage::class);
    }

    // Helper methods
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public function markEmailSent()
    {
        $this->update(['is_email_sent' => true]);
    }
}
