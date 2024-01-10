<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefermentApplication extends Model
{
    use HasFactory;
    protected $fillable =[
        'student_id',
        'Status',
        'submitted_at',
        'semester',
        'type',
        'details',
        'notes',
    ];
}
