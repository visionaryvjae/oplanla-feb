<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class ProviderBankDetails extends Model
{
    protected $fillable = [
        'provider_id',
        'account_holder',
        'bank_name', 
        'account_number',
        'branch_code',
        'account_type',
    ];

    public function provider()
    {
        return $this->belongsTo(Providers::class, 'provider_id');
    }
}
