<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class PartnerRequest extends Model
{
    protected $fillable = [
        'provider_user_id',
        'status',
        'message',
    ];

    function providerUser()
    {
        return $this->belongsTo(ProviderUser::class, 'provider_user_id');
    }

    function ownershipProofs()
    {
        return $this->hasOne(OwnershipProof::class, 'request_id');
    }

    function businessDetail()
    {
        return $this->hasOne(BusinessDetail::class, 'request_id');
    }

    function identityProofs()
    {
        return $this->hasOne(IdentityProof::class, 'request_id');
    }

    function addressProof()
    {
        return $this->hasOne(AddressProof::class, 'request_id');
    }
}
