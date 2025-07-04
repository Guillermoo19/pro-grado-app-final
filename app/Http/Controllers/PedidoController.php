<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Asegúrate de que DB esté importado

class PedidoController extends Controller
{
    /**
     * Muestra el historial de pedidos del usuario autenticado (cliente).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener solo los pedidos del usuario autenticado
        $pedidos = Auth::user()->pedidos()->with('productos')->orderBy('created_at', 'desc')->get();
        
        Log::info('PedidoController@index: Usuario ' . Auth::user()->email . ' ha accedido a sus pedidos.');

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Muestra los detalles de un pedido específico del usuario autenticado.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Pedido $pedido)
    {
        // Asegurarse de que el usuario solo pueda ver sus propios pedidos
        if ($pedido->user_id !== Auth::id()) {
            return redirect()->route('pedidos.index')->with('error', 'No tienes permiso para ver este pedido.');
        }

        // Cargar la relación 'productos' para mostrar los detalles del pedido
        $pedido->load('productos');

        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Muestra todos los pedidos para la administración (solo para administradores).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function adminIndex()
    {
        // Usar Gate para verificar si el usuario es administrador
        if (Gate::denies('viewAll', Pedido::class)) {
            Log::warning('PedidoController@adminIndex: Intento de acceso no autorizado a la gestión de pedidos por usuario ID: ' . Auth::id());
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a la gestión de pedidos.');
        }

        // Cargar todos los pedidos con sus relaciones de usuario y productos
        $pedidos = Pedido::with(['user', 'productos'])->orderBy('created_at', 'desc')->get();

        Log::info('PedidoController@adminIndex: Usuario ' . Auth::user()->email . ' ha accedido a la gestión de pedidos.');

        return view('pedidos.admin_index', compact('pedidos'));
    }

    /**
     * Muestra los detalles de un pedido específico para el administrador.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function adminShow(Pedido $pedido)
    {
        // Usar Gate para verificar si el usuario es administrador
        if (Gate::denies('viewAll', Pedido::class)) { // Reutilizamos 'viewAll' para la autorización
            Log::warning('PedidoController@adminShow: Intento de acceso no autorizado a detalles de pedido por usuario ID: ' . Auth::id());
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para ver los detalles de este pedido.');
        }

        // Cargar la relación 'productos' para mostrar los detalles del pedido
        // También cargar la relación 'user' para mostrar quién hizo el pedido en la vista de admin
        $pedido->load(['productos', 'user']);

        Log::info('PedidoController@adminShow: Administrador ' . Auth::user()->email . ' ha accedido a los detalles del pedido ID: ' . $pedido->id);

        // Reutilizamos la misma vista 'pedidos.show'
        return view('pedidos.show', compact('pedido'));
    }

    // Puedes añadir otros métodos CRUD para administradores aquí (edit, update, destroy)
    // Asegúrate de usar Gate::allows() o Gate::denies() para protegerlos.
}
