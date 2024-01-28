<?php

namespace App\Policies;

use App\Models\DefermentApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DefermentApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DefermentApplication $defermentApplication): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
       return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DefermentApplication $defermentApplication): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DefermentApplication $defermentApplication): bool
    {
        return $user->id == $defermentApplication->load('student')->student->user_id;
    }

}
