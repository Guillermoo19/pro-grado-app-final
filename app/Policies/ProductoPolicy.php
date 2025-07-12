<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Producto;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models (list products).
     * This should be accessible to all (guests, clients, admins).
     */
    public function viewAny(?User $user): bool // ?User indica que el usuario puede ser null (invitado)
    {
        // Permitir que cualquier usuario (autenticado o invitado) vea la lista de productos.
        // Si necesitas alguna restricción (ej. solo productos activos), la lógica iría aquí.
        return true;
    }

    /**
     * Determine whether the user can view a specific model (product details).
     * This should be accessible to all (guests, clients, admins).
     */
    public function view(?User $user, Producto $producto): bool // ?User indica que el usuario puede ser null (invitado)
    {
        // Permitir que cualquier usuario (autenticado o invitado) vea los detalles del producto.
        // Puedes añadir lógica aquí si, por ejemplo, solo quieres mostrar productos "activos" a los clientes.
        return true;
    }

    /**
     * Determine whether the user can create models.
     * Only accessible to admins.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin(); // Usar el método isAdmin() del modelo User
    }

    /**
     * Determine whether the user can update the model.
     * Only accessible to admins.
     */
    public function update(User $user, Producto $producto): bool
    {
        return $user->isAdmin(); // Usar el método isAdmin() del modelo User
    }

    /**
     * Determine whether the user can delete the model.
     * Only accessible to admins.
     */
    public function delete(User $user, Producto $producto): bool
    {
        return $user->isAdmin(); // Usar el método isAdmin() del modelo User
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Producto $producto): bool
    {
        return false; // Por defecto, no permitir restaurar
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Producto $producto): bool
    {
        return false; // Por defecto, no permitir eliminación forzada
    }
}
