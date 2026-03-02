<?php

namespace App\Models\Freelancing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualifications extends Model
{
    /** @use HasFactory<\Database\Factories\QualificationsFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'start_year',
        'end_year',
        'institution_name',
        'users_id'
    ];
}
