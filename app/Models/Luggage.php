<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luggage extends Model
{
    use HasFactory;

    protected $fillable = [
        'traveler_id',
        'image_path',
        'color',
        'brand_type',
        'description',
        'unique_features',
        'status',
        'lost_station',
        'date_registered',
        'date_lost',
        'date_found',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'date_registered' => 'datetime',
            'date_lost' => 'datetime',
            'date_found' => 'datetime',
        ];
    }

    //Relationships

    public function traveler()
    {
        return $this->belongsTo(Traveler::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QRCode::class);
    }

    public function qrScanLogs()
    {
        return $this->hasMany(QRScanLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Helper methods
    public function isLost()
    {
        return $this->status === 'Lost';
    }

    public function isFound()
    {
        return in_array($this->status, ['Found', 'Found(unreported)']);
    }

    public function isSafe()
    {
        return $this->status === 'Safe';
    }

    public function markAsLost($station = null)
    {
        $this->update([
            'status' => 'Lost',
            'lost_station' => $station,
            'date_lost' => now(),
        ]);
    }

    public function markAsFound($isReported = true)
    {
        $this->update([
            'status' => $isReported ? 'Found' : 'Found(unreported)',
            'date_found' => now(),
        ]);
    }

    public function markAsSafe()
{
    $this->update([
        'status' => 'Safe',
        'lost_station' => null,
        'date_lost' => null,
        'comment' => null,
    ]);
}



}
