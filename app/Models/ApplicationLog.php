<?php

namespace App\Models;

use App\Contract\Repository\DALoggerRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model implements DALoggerRepositoryInterface
{
    use HasFactory;
    protected $fillable=[
        'application_id',
        'changed_by',
        'changed_at',
        'previous_status',
        'new_status',
        'remarks',
        'action_type',
    ];

    public function defermentApplication()
    {
      return $this->belongsTo(DefermentApplication::class,'application_id','id');
    }
    public function User()
    {
        return $this->hasOne(User::class,'id','changed_by')->first();
    }
    public function changeByUser()
    {
        $user = $this->User();
        switch ($user->role){
            case 'faculty':
                $supervisor = $this->defermentApplication->student->supervisors()->where('user_id',$user->id)->first();
                return !empty($supervisor->pivot) && $supervisor->pivot->supervisor_type == 'main' ? 'supervisor' : '';
            default:
                return '';
        }
    }
}
