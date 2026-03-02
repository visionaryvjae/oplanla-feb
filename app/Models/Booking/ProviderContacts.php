<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderContacts extends Model
{
    /** @use HasFactory<\Database\Factories\Booking\ProviderContactsFactory> */
    use HasFactory;

    protected $fillable =[
        'phone',
        'email',
        'providers_id'
    ];
}
