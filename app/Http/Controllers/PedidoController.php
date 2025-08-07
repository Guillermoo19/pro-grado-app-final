<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    /**
     * Muestra la lista de pedidos del usuario autenticado (cliente).
     */
    public function index()
    {
        $pedidos = Auth::user()->pedidos()->orderBy('created_at', 'desc')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Muestra los detalles de un pedido específico del usuario autenticado (cliente).
     */
    public function show(Pedido $pedido)
    {
        // Asegúrate de que el usuario autenticado sea el dueño del pedido
        if ($pedido->user_id !== Auth::id()) {
            abort(403, 'Acceso no autorizado a este pedido.');
        }
        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Muestra la lista de todos los pedidos para el administrador.
     * Esta es la versión modificada para mostrar dos listas.
     */
    public function adminIndex()
    {
        Log::info('PedidoController@adminIndex: Usuario ' . Auth::user()->email . ' ha accedido a la gestión de pedidos.');
        
        // Obtener pedidos pendientes o en proceso
        $pedidosPendientes = Pedido::whereIn('estado_pedido', ['pendiente', 'en_preparacion', 'en_camino'])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Obtener pedidos ya entregados y pagados
        $pedidosCompletados = Pedido::where('estado_pedido', 'entregado')
            ->where('estado_pago', 'pagado')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pedidos.index', compact('pedidosPendientes', 'pedidosCompletados'));
    }

    /**
     * Muestra los detalles de un pedido específico para el administrador.
     */
    public function adminShow(Pedido $pedido)
    {
        // El middleware 'can:access-admin' ya protege esta ruta, así que no necesitamos una verificación de usuario aquí.
        $pedido->load('productos');
        return view('admin.pedidos.show', compact('pedido'));
    }

    /**
     * Actualiza el estado del pedido desde el panel de administración.
     */
    public function updateEstadoPedido(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado_pedido' => 'required|in:pendiente,en_preparacion,en_camino,entregado,cancelado',
        ]);

        $pedido->update(['estado_pedido' => $request->estado_pedido]);

        return back()->with('success', 'Estado del pedido actualizado con éxito.');
    }

    /**
     * Actualiza el estado del pago desde el panel de administración.
     */
    public function updateEstadoPago(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado_pago' => 'required|in:pendiente,pendiente_revision,pagado,rechazado',
        ]);

        $pedido->update(['estado_pago' => $request->estado_pago]);

        return back()->with('success', 'Estado del pago actualizado con éxito.');
    }
}
