<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; // Importar la fachada Gate

class PedidoController extends Controller
{
    /**
     * Muestra el historial de pedidos del usuario autenticado.
     */
    public function index()
    {
        // Un usuario normal solo puede ver sus propios pedidos
        // Un administrador puede ver todos los pedidos a través de adminIndex
        Gate::authorize('viewAny', Pedido::class); // Autorización para ver sus propios pedidos

        $pedidos = Auth::user()->pedidos()->with('user', 'detallePedidos.producto')->latest()->get();
        
        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Muestra la lista de todos los pedidos (para administradores).
     */
    public function adminIndex()
    {
        // Solo usuarios con rol 'admin' pueden acceder a esta vista
        Gate::authorize('viewAll', Pedido::class); // Nueva habilidad de autorización

        // Carga todos los pedidos, con la relación de usuario y detalles de producto
        $pedidos = Pedido::with('user', 'detallePedidos.producto')->latest()->get();

        return view('pedidos.admin_index', compact('pedidos'));
    }


    /**
     * Muestra los detalles de un pedido específico.
     */
    public function show(Pedido $pedido)
    {
        // Autorizar que el usuario puede ver este pedido
        Gate::authorize('view', $pedido);

        // Carga las relaciones necesarias para la vista de detalles
        $pedido->load('user', 'detallePedidos.producto');
        
        return view('pedidos.show', compact('pedido'));
    }

    // No necesitamos métodos create, store, edit, update, destroy directamente para Pedidos por ahora,
    // ya que se crean a través del checkout y se gestionan con adminIndex/show para ver/actualizar estado.
    // Si en el futuro necesitas un CRUD completo para pedidos, se añadirían aquí.
}

