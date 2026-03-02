<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /** @use HasFactory<\Database\Factories\Booking\PhotoFactory> */
    use HasFactory;

    public function provider()
    {
        return $this->belongsTo(Providers::class);
    }

    protected $fillable = [
        'image',
        'area',
        'providers_id',
        'rooms_id',
    ];
}
