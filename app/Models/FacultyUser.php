<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyUser extends User
{
    public static function boot() {
        parent::boot();

        static::addGlobalScope('role', function (Builder $builder) {
            $builder->where('role',  'faculty');
        });
    }

}
