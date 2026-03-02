<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'name', // e.g., "CoJ Domestic Step 1"
        'block_limit', // e.g., 350 (kWh)
        'price_per_unit', // Rand value
        'tier_level' // 1, 2, or 3
    ];
}
