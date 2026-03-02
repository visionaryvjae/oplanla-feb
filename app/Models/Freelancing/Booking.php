<?php

namespace App\Models\Freelancing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $fillable =[
        'status',
        'booking_address',
        'booking_date',
        'projects_id',
        'users_id'
    ];


}
