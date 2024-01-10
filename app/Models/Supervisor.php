<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone_number',
        'department',
        'title',
        'research_interests',
        'office_location',
        'max_students',
    ];
}
