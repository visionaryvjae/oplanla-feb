<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class BusinessDetail extends Model
{
    protected $fillable = [
        'request_id',
        'Business_license_path',
        'business_license_name',
        'Tax_registration_number_path',
        'tax_number_name',
        'Website',
        'status',
        'reason',
    ];

    function request()
    {
        return $this->belongsTo(PartnerRequest::class, 'request_id');
    }
}
