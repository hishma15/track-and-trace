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

    public function scopePending($query)   //used for admin to view pending staff approval
    {
        return $query->where('approval_status', 'pending');
    }

    public function scopeApproved($query)  //used for admin to view approved staff
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopeRejected($query)   //used for admin to view rejected staff
    {
        return $query->where('approval_status', 'rejected');
    }


}
