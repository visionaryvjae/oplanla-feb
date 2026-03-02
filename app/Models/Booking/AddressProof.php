<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class AddressProof extends Model
{
    protected $fillable = [
        'request_id',
        'document_type',
        'address_proof_path',
        'original_name',
        'status',
        'reason',
    ];

    function request()
    {
        return $this->belongsTo(PartnerRequest::class, 'request_id');
    }
}
