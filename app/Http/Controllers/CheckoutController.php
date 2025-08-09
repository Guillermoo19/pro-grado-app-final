<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Muestra la página de confirmación del pedido.
     * @param Pedido $pedido El modelo Pedido inyectado por Route Model Binding
     */
    public function confirm(Pedido $pedido)
    {
        // Verificar que el pedido pertenezca al usuario actual.
        if (auth()->check() && $pedido->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Cargar las relaciones necesarias.
        // La relación 'detalles.producto' permite acceder a los detalles del pedido y a los productos relacionados.
        $pedido->load('detalles.producto');
        
        // Obtener el único registro de configuración para mostrar los datos bancarios.
        $configuracion = Configuracion::first() ?? new Configuracion();

        // Pasar el pedido y la configuración a la vista. El total ya está guardado en el modelo $pedido.
        return view('checkout.confirm', compact('pedido', 'configuracion'));
    }

    /**
     * Sube el comprobante de pago y actualiza el pedido.
     */
    public function uploadProof(Request $request, Pedido $pedido)
    {
        $rules = [
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'tipo_entrega' => 'required|in:recoger_local,domicilio',
        ];

        if ($request->input('tipo_entrega') === 'domicilio') {
            $rules['direccion_entrega'] = 'required|string|max:255';
            $rules['telefono_contacto'] = 'required|string|max:20';
        } else {
            // Si el tipo de entrega no es 'domicilio', los campos deben ser anulables
            $rules['direccion_entrega'] = 'nullable|string|max:255';
            $rules['telefono_contacto'] = 'nullable|string|max:20';
        }

        $request->validate($rules);

        // Se usa una transacción para asegurar que todas las operaciones se completen con éxito.
        DB::beginTransaction();
        try {
            $imagePath = $request->file('proof_image')->store('proofs', 'public');
            
            $pedido->update([
                'comprobante_url' => $imagePath,
                'estado_pago' => 'pendiente_revision',
                'tipo_entrega' => $request->input('tipo_entrega'),
                'direccion_entrega' => $request->input('direccion_entrega'),
                'telefono_contacto' => $request->input('telefono_contacto'),
            ]);

            DB::commit();
            return back()->with('success', 'Comprobante de pago y detalles de entrega subidos con éxito. Tu pago está pendiente de revisión.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al subir comprobante o guardar detalles de entrega: " . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Hubo un error al procesar tu solicitud: ' . $e->getMessage());
        }
    }
}
