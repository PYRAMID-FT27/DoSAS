<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'ic',
        'nationality',
        'program_code',
    ];

    public function supervisors(): BelongsToMany
    {
      return  $this->belongsToMany(Supervisor::class,'student_supervisor','student_id','supervisor_id')
                  ->withPivot('supervisor_type');
    }
}
