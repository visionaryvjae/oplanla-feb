<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFacilities extends Model
{
    /** @use HasFactory<\Database\Factories\Booking\RoomFacilitiesFactory> */
    use HasFactory;

    protected $fillable = [
        'Flat Screen TV', 
        'Private Bathroom',
        'Terrace',
        'Hot Tub',
        'View',
        'Balcony',
        'Washing Machine',
        'Air Conditioning',
        'Private Pool',
        'fireplace',
        'pool cover',
        'mountain view',
        'infinity pool',
        'Sauna',
        'Salt Water Pool',
        'Computer',
        'Gam Console',
        'Yukata',
        'Lake View',
        'Complimentary evening snacks',
        'Reading Light',
        'Sea View',
        'rooms_id'
    ];
}
