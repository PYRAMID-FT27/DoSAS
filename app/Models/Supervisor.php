<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supervisor extends Model
{
    use HasFactory;
    protected $fillable = [
        'department',
        'title',
        'research_interests',
        'office_location',
        'max_students',
        'user_id',
    ];

    /**
     * @return BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class,'student_supervisor','supervisor_id','student_id')
            ->withPivot('supervisor_type');
    }
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
