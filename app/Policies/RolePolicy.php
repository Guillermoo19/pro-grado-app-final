<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role; // Importa el modelo Role
use Illuminate\Auth\Access\Response; // Importa la clase Response
use Illuminate\Auth\Access\HandlesAuthorization; // Importa el trait HandlesAuthorization

class RolePolicy
{
    use HandlesAuthorization; // Usa el trait para helpers como deny/allow

    /**
     * Determine whether the user can view any models.
     * Permite que solo los administradores vean la lista de roles.
     */
    public function viewAny(User $user): bool
    {
        // Un usuario puede ver la lista de roles si su rol es 'admin'
        return $user->role && $user->role->nombre === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     * Este método es para ver un rol específico. Si no lo necesitas, puedes dejarlo igual o borrarlo.
     */
    public function view(User $user, Role $role): bool
    {
        // Por ahora, si puede ver la lista, puede ver cualquier rol.
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     * Permite que solo los administradores creen roles.
     */
    public function create(User $user): bool
    {
        // Un usuario puede crear roles si su rol es 'admin'
        return $user->role && $user->role->nombre === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     * Permite que solo los administradores actualicen roles.
     */
    public function update(User $user, Role $role): bool
    {
        // Un usuario puede actualizar roles si su rol es 'admin'
        return $user->role && $user->role->nombre === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     * Permite que solo los administradores eliminen roles.
     */
    public function delete(User $user, Role $role): bool
    {
        // Un usuario puede eliminar roles si su rol es 'admin'
        return $user->role && $user->role->nombre === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        // No implementado para este CRUD
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        // No implementado para este CRUD
        return false;
    }
}