<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QRCode extends Model
{
    use HasFactory;

    protected $table = 'qr_codes';

    protected $fillable = [
        'luggage_id',
        'qr_code_data',
        'qr_image_path',
        'unique_code', 
        'is_active',
        'date_created',
    ];

    protected function casts(): array
    {
        return [
            'date_created' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // Auto-generate unique code when creating QR code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($qrCode) {
            if (empty($qrCode->unique_code)) {
                $qrCode->unique_code = self::generateUniqueCode();
            }
        });
    }

    // Generate unique code like "djfe37242"
    public static function generateUniqueCode()
    {
        do {
            // Generate 4 random letters + 5 random numbers
            $letters = Str::random(4);
            $numbers = rand(10000, 99999);
            $code = strtolower($letters) . $numbers;
        } while (self::where('unique_code', $code)->exists());

        return $code;
    }

    // Relationships
    public function luggage()
    {
        return $this->belongsTo(Luggage::class);
    }

    // Helper methods
    public function isActive()
    {
        return $this->is_active;
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function activate()
    {
        $this->update(['is_active' => true]);
    }
}