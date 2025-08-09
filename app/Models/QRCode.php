<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    use HasFactory;

    protected $table = 'qr_codes';

    protected $fillable = [
        'luggage_id',
        'qr_code_data',
        'qr_image_path',
        'pdf_path',
        'is_active',
        'date_created',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'date_created' => 'datetime',
        ];
    }

    // Relationships
    public function luggage()
    {
        return $this->belongsTo(Luggage::class);
    }

    // Helper methods
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function activate()
    {
        $this->update(['is_active' => true]);
    }
}
