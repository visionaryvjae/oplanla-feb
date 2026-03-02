<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class IdentityProof extends Model
{
    protected $fillable = [
        'request_id',
        'document_type',
        'id_proof_path',
        'original_name',
        'status',
        'reason',
    ];

    function request()
    {
        return $this->belongsTo(PartnerRequest::class, 'request_id');
    }
}
