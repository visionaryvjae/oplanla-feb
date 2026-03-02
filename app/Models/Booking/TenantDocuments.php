<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Model;

class TenantDocuments extends Model
{
    protected $fillable = [
        'id_copy',
        'pay_slips',
        'bank_statements',
        'proof_of_address',
        'marriage_certificate',
        'work_permit',
        'comments',
        'all_documents_verified',
        'users_id',
    ];


    public function tenant()
    {
        $this->belongsTo(User::class, 'users_id');
    }
}
