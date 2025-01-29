<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    
    // La funcion viewAny permite ver todo a los usuarios que tengan los roles especificados
    public function viewAny(User $user): bool
    {
        return $user->hasRole(roles: ['Super Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasRole(['Super Admin']);
    }

    /**
     * Determine whether the user can create models.
     */

    // La funcion create permite crear a los usuarios que tengan los roles especificados
    public function create(User $user): bool
    {
        return $user->hasRole(['Super Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */

     // La funcion update permite actualizar a los usuarios que tengan los roles especificados
    public function update(User $user): bool
    {
        return $user->hasRole(['Super Admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */

     // La funcion delete permite eliminar a los usuarios que tengan los roles especificados
    public function delete(User $user): bool
    {
        return $user->hasRole(['Super Admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole(['Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole(['Super Admin']);
    }
}
