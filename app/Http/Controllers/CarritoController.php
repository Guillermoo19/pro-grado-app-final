<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    /**
     * Muestra el contenido del carrito.
     */
    public function index()
    {
        $carrito = Session::get('carrito', []);
        $productosEnCarrito = [];
        $total = 0;

        foreach ($carrito as $itemKey => $item) {
            $producto = Producto::find($item['id']);

            if ($producto) {
                $subtotalItem = $producto->precio * $item['cantidad'];
                
                $ingredientesAdicionales = [];
                // Se cargan los objetos de ingredientes para mostrarlos en la vista
                if (isset($item['ingredientes']) && is_array($item['ingredientes'])) {
                    foreach ($item['ingredientes'] as $ingredienteId) {
                        $ingrediente = Ingrediente::find($ingredienteId);
                        if ($ingrediente) {
                            $subtotalItem += $ingrediente->precio;
                            $ingredientesAdicionales[] = $ingrediente;
                        }
                    }
                }
                
                $total += $subtotalItem;

                $productosEnCarrito[] = [
                    'item_key' => $itemKey,
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio,
                    'cantidad' => $item['cantidad'],
                    'imagen' => $producto->imagen,
                    'subtotal' => $subtotalItem,
                    'ingredientes_adicionales' => $ingredientesAdicionales,
                ];
            } else {
                // Si el producto no se encuentra, lo eliminamos del carrito
                Session::forget("carrito.$itemKey");
            }
        }

        return view('carrito.index', compact('productosEnCarrito', 'total'));
    }

    /**
     * Agrega un producto al carrito.
     */
    public function agregar(Request $request)
    {
        $productoId = $request->input('producto_id');
        $cantidad = $request->input('cantidad', 1);
        $ingredientesIds = $request->input('ingredientes', []); 
        
        $producto = Producto::find($productoId);

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        if ($cantidad <= 0) {
            return back()->with('error', 'La cantidad debe ser al menos 1.');
        }

        $carrito = Session::get('carrito', []);

        // Generar una clave única para el item que incluye el producto y los ingredientes.
        // Esto evita que un producto con ingredientes se confunda con uno sin ellos.
        $ingredientesKey = implode('-', $ingredientesIds);
        $itemKey = $productoId . ($ingredientesKey ? '-' . $ingredientesKey : '');

        if (isset($carrito[$itemKey])) {
            $carrito[$itemKey]['cantidad'] += $cantidad;
        } else {
            $carrito[$itemKey] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'imagen' => $producto->imagen, 
                'cantidad' => $cantidad,
                'ingredientes' => $ingredientesIds,
            ];
        }

        Session::put('carrito', $carrito);

        return back()->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     */
    public function actualizar(Request $request)
    {
        $itemKey = $request->input('item_key');
        $cantidad = $request->input('cantidad');

        $carrito = Session::get('carrito', []);

        if (!isset($carrito[$itemKey])) {
            return back()->with('error', 'Producto no encontrado en el carrito.');
        }

        if ($cantidad <= 0) {
            unset($carrito[$itemKey]);
            Session::put('carrito', $carrito);
            return back()->with('success', 'Producto eliminado del carrito.');
        }

        $carrito[$itemKey]['cantidad'] = $cantidad;
        Session::put('carrito', $carrito);

        return back()->with('success', 'Cantidad del producto actualizada.');
    }

    /**
     * Elimina un producto del carrito.
     */
    public function eliminar(Request $request)
    {
        $itemKey = $request->input('item_key');

        $carrito = Session::get('carrito', []);

        if (isset($carrito[$itemKey])) {
            unset($carrito[$itemKey]);
            Session::put('carrito', $carrito);
            return back()->with('success', 'Producto eliminado del carrito.');
        }

        return back()->with('error', 'Producto no encontrado en el carrito.');
    }

    /**
     * Procesa el checkout del carrito.
     */
    public function checkout(Request $request)
    {
        $carrito = Session::get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        DB::beginTransaction();
        try {
            $totalPedido = 0;
            $itemsParaAdjuntar = [];

            foreach ($carrito as $item) {
                $producto = Producto::find($item['id']);
                if (!$producto) {
                    throw new \Exception("Producto con ID {$item['id']} no encontrado.");
                }

                // Calcular el subtotal del ítem, incluyendo el precio del producto y los ingredientes
                $totalItem = $producto->precio * $item['cantidad'];
                
                $ingredientesAdicionales = [];
                if (isset($item['ingredientes']) && is_array($item['ingredientes'])) {
                    foreach ($item['ingredientes'] as $ingredienteId) {
                        $ingrediente = Ingrediente::find($ingredienteId);
                        if ($ingrediente) {
                            $totalItem += $ingrediente->precio;
                            $ingredientesAdicionales[] = [
                                'id' => $ingrediente->id,
                                'nombre' => $ingrediente->nombre,
                                'precio' => $ingrediente->precio,
                            ];
                        }
                    }
                }

                $totalPedido += $totalItem;

                // Preparar los datos para adjuntar, ahora incluyendo el subtotal
                $itemsParaAdjuntar[$producto->id] = [
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $totalItem, // <-- ¡Aquí está la corrección!
                    'ingredientes_adicionales' => json_encode($ingredientesAdicionales),
                ];

                // Decrementar el stock
                if ($producto->stock !== null) {
                    $producto->decrement('stock', $item['cantidad']);
                }
            }

            // Crear el pedido con el total calculado
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => $totalPedido,
                'estado_pedido' => 'pendiente',
                'estado_pago' => 'pendiente',
                'tipo_entrega' => $request->input('tipo_entrega', 'recoger_local'),
                'direccion_entrega' => $request->input('direccion_entrega'),
                'telefono_contacto' => $request->input('telefono_contacto'),
            ]);

            // Adjuntar todos los productos al pedido a la vez
            $pedido->productos()->attach($itemsParaAdjuntar);

            Session::forget('carrito');
            DB::commit();

            return redirect()->route('checkout.confirm', $pedido->id)->with('success', 'Pedido realizado con éxito. Por favor, sube tu comprobante de pago.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al procesar el checkout: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('carrito.index')->with('error', 'Hubo un error al procesar tu pedido: ' . $e->getMessage());
        }
    }

    /**
     * Muestra la página de confirmación de pedido.
     */
    public function confirm($pedidoId)
    {
        $pedido = Pedido::findOrFail($pedidoId);
        return view('checkout.confirm', compact('pedido'));
    }

    /**
     * Sube el comprobante de pago para un pedido.
     */
    public function uploadProof(Request $request, Pedido $pedido)
    {
        $rules = [
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif,pdf,svg|max:2048',
            'tipo_entrega' => 'required|in:recoger_local,domicilio',
        ];

        if ($request->input('tipo_entrega') === 'domicilio') {
            $rules['direccion_entrega'] = 'required|string|max:255';
            $rules['telefono_contacto'] = 'required|string|max:20';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $pedido->update([
                'tipo_entrega' => $request->input('tipo_entrega'),
                'direccion_entrega' => $request->input('direccion_entrega'),
                'telefono_contacto' => $request->input('telefono_contacto'),
            ]);

            if ($request->hasFile('proof_image')) {
                $imagePath = $request->file('proof_image')->store('proofs', 'public');
                $pedido->update([
                    'comprobante_url' => $imagePath,
                    'estado_pago' => 'pendiente_revision',
                ]);
            }

            DB::commit();
            return back()->with('success', 'Comprobante de pago y detalles de entrega subidos con éxito. Tu pago está pendiente de revisión.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al subir comprobante o guardar detalles de entrega: " . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Hubo un error al procesar tu solicitud: ' . $e->getMessage());
        }
    }
}
