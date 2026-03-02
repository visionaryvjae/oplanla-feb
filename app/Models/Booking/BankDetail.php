<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class BankDetail extends Model
{
    
    // use SoftDeletes;
    
    protected $fillable = [
        'providers_id',
        'bank_name',
        'account_number',
        'account_holder_name',
    ];

    public function provider()
    {
        return $this->belongTo(Provider::class, 'providers_id');    
    }
}
