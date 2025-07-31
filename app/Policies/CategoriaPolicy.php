<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoriaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Solo los administradores pueden ver cualquier categoría en el panel de administración
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Categoria $categoria): bool
    {
        // Si tienes una vista para el detalle de la categoría, solo los administradores deberían verla
        // Si esta ruta no es para el admin, podrías ajustar la lógica.
        // Por ahora, asumimos que solo los admins pueden ver detalles de categorías en el panel.
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo los administradores pueden crear categorías
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Categoria $categoria): bool
    {
        // Solo los administradores pueden actualizar categorías
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Categoria $categoria): bool
    {
        // Solo los administradores pueden eliminar categorías
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Categoria $categoria): bool
    {
        // Por lo general, solo los administradores pueden restaurar categorías eliminadas (soft deletes)
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Categoria $categoria): bool
    {
        // Por lo general, solo los administradores pueden eliminar permanentemente categorías
        return $user->isAdmin();
    }
}
