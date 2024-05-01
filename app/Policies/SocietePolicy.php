<?php

namespace App\Policies;

use App\Models\Societé;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class SocietePolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Societé $societé): bool
    {
        return true ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
{
    // Vérifier si l'utilisateur est un administrateur
    if ($user->isAdmin()) {
        return true;
    }

    return false;
}

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Societé $societé): bool
    {
        return true ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Societé $societé): bool
    {
        return true ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Societé $societé): bool
    {
        return true ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Societé $societé): bool
    {
        return true ;
    }
}
