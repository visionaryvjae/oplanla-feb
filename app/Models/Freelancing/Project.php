<?php

namespace App\Models\Freelancing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable =[
        'title',
        'description',
        'price',
        'skills',
        'users_id'
    ];
}
