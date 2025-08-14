<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any users (list users).
     * Only accessible to admins.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view a specific user.
     * Only accessible to admins.
     */
    public function view(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create users.
     */
    public function create(User $user): bool
    {
        return false; 
    }

    /**
     * Determine whether the user can update a specific user.
     * Only accessible to admins. Super admin can edit anyone.
     * Regular admin cannot edit super admin.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->isAdmin() && !$model->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete a specific user.
     * Only accessible to admins. Super admin can delete anyone.
     * Regular admin cannot delete super admin or themselves.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id; // Super admin cannot delete themselves
        }

        return $user->isAdmin() && !$model->isSuperAdmin() && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false; // Not implemented
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false; // Not implemented
    }
}
