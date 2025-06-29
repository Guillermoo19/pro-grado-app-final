<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pedido;
use Illuminate\Auth\Access\Response;

class PedidoPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * Este método controla si un usuario puede ver la lista de pedidos.
     * Para 'Mis Pedidos', un usuario normal solo ve los suyos.
     * Un administrador debería poder ver la lista general (todos los pedidos).
     */
    public function viewAny(User $user): bool
    {
        // Un usuario autenticado siempre puede ver la lista de "Mis Pedidos".
        // La lógica dentro del controlador (Auth::user()->pedidos()) ya filtra por usuario.
        return $user !== null; // Permitir que cualquier usuario autenticado acceda a su lista de pedidos
    }

    /**
     * Determine whether the user can view the model.
     *
     * Este método controla si un usuario puede ver los detalles de un pedido específico.
     */
    public function view(User $user, Pedido $pedido): bool
    {
        // Un administrador siempre puede ver cualquier pedido.
        // Un usuario normal solo puede ver los detalles de sus propios pedidos.
        return $user->isAdmin() || $user->id === $pedido->user_id;
    }

    /**
     * Determine whether the user can create models.
     * (Los pedidos se crean a través del checkout, no directamente por un CRUD manual)
     */
    public function create(User $user): bool
    {
        // La creación de pedidos se maneja internamente por el checkout, no directamente por un usuario.
        // Sin embargo, si hubiera una interfaz para "crear un pedido manualmente" (ej. para admins), aquí se controlaría.
        return $user->isAdmin() || $user->role->name === 'cliente'; // Permite a clientes y admins "crear" (vía checkout)
    }

    /**
     * Determine whether the user can update the model.
     * (Principalmente para cambiar el estado del pedido por administradores)
     */
    public function update(User $user, Pedido $pedido): bool
    {
        // Solo los administradores pueden actualizar un pedido (ej. cambiar estado).
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pedido $pedido): bool
    {
        // Solo los administradores pueden eliminar pedidos.
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pedido $pedido): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pedido $pedido): bool
    {
        return $user->isAdmin();
    }
}
