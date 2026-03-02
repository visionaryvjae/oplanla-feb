<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledEmail extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduledEmailFactory> */
    use HasFactory;

    protected $fillable = [
        'to',
        'users_id',
        'subject',
        'body',
        'send_at',
        'sent'
    ];
}
