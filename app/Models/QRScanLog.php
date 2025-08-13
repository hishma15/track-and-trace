<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRScanLog extends Model
{
    use HasFactory;

    protected $table = 'qr_scan_logs';

    protected $fillable = [
        'staff_id',
        'luggage_id',
        'action',
        'comment',
        'scan_location',
        'scan_datetime',
    ];

    protected function casts(): array
    {
        return [
            'scan_datetime' => 'datetime',
        ];
    }

    // Relationships
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function luggage()
    {
        return $this->belongsTo(Luggage::class);
    }
}
