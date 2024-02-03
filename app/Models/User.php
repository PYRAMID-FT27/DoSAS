<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'metric_no',
        'role',
        'phone_number',
        'first_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function isFirstLogin()
    {
       return empty($this->first_login_at);
    }

    public function student()
    {
        return $this->hasOne(Student::class,'user_id');
    }
    public function supervisor()
    {
      return  $this->hasOne(Supervisor::class,'user_id');
    }

    public function meta()
    {
        if ($this->isStudent()) return $this->load('student')->student()->first();
        if ($this->isFaculty()) return $this->load('supervisor')->supervisor()->first();
        return null;
    }
    public function isStudent()
    {
        return $this->role == 'student';
    }
    public function isFaculty()
    {
        return $this->role == 'faculty';
    }
    public function isStaff()
    {
        return $this->role == 'staff';
    }

}
