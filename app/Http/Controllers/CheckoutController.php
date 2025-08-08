<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Muestra la página de confirmación del pedido.
     */
    public function confirm(Pedido $pedido)
    {
        // Verificar que el pedido pertenezca al usuario actual.
        if (auth()->check() && $pedido->user_id !== auth()->id()) {
            abort(403);
        }

        // Obtener el único registro de configuración.
        // Si no existe, crea un objeto vacío para evitar errores en la vista.
        $configuracion = Configuracion::first() ?? new Configuracion();

        return view('checkout.confirm', compact('pedido', 'configuracion'));
    }

    /**
     * Sube el comprobante de pago y actualiza el pedido.
     */
    public function uploadProof(Request $request, Pedido $pedido)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'tipo_entrega' => 'required|in:recoger_local,domicilio',
            'direccion_entrega' => 'nullable|required_if:tipo_entrega,domicilio|string|max:255',
            'telefono_contacto' => 'nullable|required_if:tipo_entrega,domicilio|string|max:20',
        ]);
    
        // Guarda la imagen del comprobante y actualiza el pedido
        $imageName = time().'.'.$request->proof_image->extension();
        $request->proof_image->move(public_path('images/comprobantes'), $imageName);
    
        $pedido->update([
            'estado' => 'pagado',
            'comprobante_url' => 'images/comprobantes/'.$imageName,
            'tipo_entrega' => $request->tipo_entrega,
            'direccion_entrega' => $request->direccion_entrega,
            'telefono_contacto' => $request->telefono_contacto,
        ]);
    
        return redirect()->route('pedidos.index')->with('success', 'Comprobante de pago subido con éxito y detalles de entrega guardados.');
    }
}
