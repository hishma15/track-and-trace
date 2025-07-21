<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization',
        'position',
        'staff_official_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function qrScanLogs()
    {
        return $this->hasMany(QrScanLog::class);
    }

    public function getFullNameAttribute()
    {
        return $this->user->full_name;
    }


}
