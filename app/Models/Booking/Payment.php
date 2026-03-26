<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Payment extends Model
{
    protected $fillable = [
        'pop_path', // Storage path for the PoP file
        'payment_type',
        'status',
        'amount',
        'invoice_number',
        'provider_id',
        'tenant_id',
        'charge_id',
        'uploaded_at',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function provider()
    {
        return $this->belongsTo(Providers::class, 'provider_id');
    }

    public function charge()
    {
        return $this->belongsTo(Charge::class, 'charge_id');
    }
}
