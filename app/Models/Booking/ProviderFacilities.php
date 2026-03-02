<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderFacilities extends Model
{
    /** @use HasFactory<\Database\Factories\Booking\ProviderFacilitiesFactory> */
    use HasFactory;

    protected $fillable = [
        'outdoor pool',
        'non-smoking rooms',
        'Free Parking',
        'Free Wifi',
        'Family Rooms',
        'Garden',
        'Braai Facilities',
        'laundry',
        'tea/coffee maker',
        'Breakfast',
        'fitness center',
        'wheelchair support',
        'Restaurant',
        'Bar',
        '24 hour front desk',
        'Airport Shuttle',
        'Room Service',
        'HotTub/ Jacuzzi',
        'Spa and Wellness Center',
        'Electrical Vehicle Charging',
        'providers_id'
    ];
}
