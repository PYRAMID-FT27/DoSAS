<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function applicationLog(): HasMany
    {
        return $this->hasMany(ApplicationLog::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
