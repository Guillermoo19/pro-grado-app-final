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
     */
    public function adminIndex()
    {
        Log::info('PedidoController@adminIndex: Usuario ' . Auth::user()->email . ' ha accedido a la gestión de pedidos.');
        
        // Se obtienen todos los pedidos con los usuarios relacionados para evitar consultas N+1
        $pedidos = Pedido::with('user')->get();

        // Se inicializan las colecciones para cada tipo de pedido
        $pedidosPendientes = collect();
        $pedidosCompletados = collect();
        $pedidosCanceladosPagados = collect();
        $pedidosRechazados = collect();
        
        // Iterar sobre cada pedido para clasificarlo
        foreach ($pedidos as $pedido) {
            // Se considera "Rechazado" si el estado de pago es 'rechazado'
            if ($pedido->estado_pago === 'rechazado') {
                $pedidosRechazados->push($pedido);
            }
            // Se considera "Completado" si su estado es 'entregado'
            elseif ($pedido->estado_pedido === 'entregado') {
                $pedidosCompletados->push($pedido);
            }
            // Un pedido se considera "Cancelado y Pagado" si el estado de pedido es 'cancelado' Y el estado de pago es 'pagado' o 'reembolsado'
            elseif ($pedido->estado_pedido === 'cancelado' && ($pedido->estado_pago === 'pagado' || $pedido->estado_pago === 'reembolsado')) {
                $pedidosCanceladosPagados->push($pedido);
            }
            // Cualquier otro caso, incluyendo 'reembolso_pendiente', se considera "Pendiente"
            else {
                // Si el estado es 'reembolso_pendiente', lo cambiamos a 'pendiente' para la vista
                if ($pedido->estado_pedido === 'reembolso_pendiente') {
                    $pedido->estado_pedido = 'pendiente';
                }
                $pedidosPendientes->push($pedido);
            }
        }

        return view('admin.pedidos.index', compact('pedidosPendientes', 'pedidosCompletados', 'pedidosRechazados', 'pedidosCanceladosPagados'));
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
     * Elimina un pedido del sistema.
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return back()->with('success', 'Pedido eliminado con éxito.');
    }

    /**
     * Actualiza el estado del pedido desde el panel de administración.
     */
    public function updateEstadoPedido(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado_pedido' => 'required|in:pendiente,en_preparacion,en_camino,entregado,cancelado',
        ]);
        
        // Simplemente actualiza el estado del pedido.
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
    
    /**
     * Marca un pedido como reembolsado, moviéndolo a un estado final.
     */
    public function marcarReembolsado(Pedido $pedido)
    {
        // Actualiza el estado del pedido y el estado de pago.
        $pedido->update([
            'estado_pedido' => 'cancelado',
            'estado_pago' => 'reembolsado'
        ]);

        return back()->with('success', 'El pedido ha sido marcado como reembolsado y cancelado.');
    }
}
