<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
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
        // Obtener el carrito de la sesión. Si no existe, es un array vacío.
        $carrito = Session::get('carrito', []);
        $productosEnCarrito = [];
        $total = 0;

        // Iterar sobre los ítems del carrito para obtener los detalles del producto
        // y calcular el subtotal de cada uno y el total general.
        foreach ($carrito as $id => $item) {
            $producto = Producto::find($id); // Recupera el producto completo de la DB

            if ($producto) {
                $subtotalItem = $producto->precio * $item['cantidad'];
                $total += $subtotalItem;

                $productosEnCarrito[] = [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio,
                    'cantidad' => $item['cantidad'],
                    'imagen' => $producto->imagen, // Asegúrate de que la imagen se carga
                    'subtotal' => $subtotalItem,
                ];
            } else {
                // Si el producto no se encuentra (ej. fue eliminado), lo quitamos del carrito
                Session::forget("carrito.$id");
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
        $cantidad = $request->input('cantidad');

        $producto = Producto::find($productoId);

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        if ($cantidad <= 0) {
            return back()->with('error', 'La cantidad debe ser al menos 1.');
        }

        // Obtener el carrito actual de la sesión
        $carrito = Session::get('carrito', []);

        // Si el producto ya está en el carrito, actualiza la cantidad
        if (isset($carrito[$productoId])) {
            $carrito[$productoId]['cantidad'] += $cantidad;
        } else {
            // Si no está, añade el producto con sus detalles
            $carrito[$productoId] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'imagen' => $producto->imagen, // Guarda la imagen para mostrarla en el carrito
                'cantidad' => $cantidad,
            ];
        }

        // Guardar el carrito actualizado en la sesión
        Session::put('carrito', $carrito);

        return back()->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     */
    public function actualizar(Request $request)
    {
        $productoId = $request->input('producto_id');
        $cantidad = $request->input('cantidad');

        $carrito = Session::get('carrito', []);

        if (!isset($carrito[$productoId])) {
            return back()->with('error', 'Producto no encontrado en el carrito.');
        }

        if ($cantidad <= 0) {
            // Si la cantidad es 0 o menos, eliminamos el producto del carrito
            unset($carrito[$productoId]);
            Session::put('carrito', $carrito);
            return back()->with('success', 'Producto eliminado del carrito.');
        }

        $producto = Producto::find($productoId);
        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        $carrito[$productoId]['cantidad'] = $cantidad;
        Session::put('carrito', $carrito);

        return back()->with('success', 'Cantidad del producto actualizada.');
    }

    /**
     * Elimina un producto del carrito.
     */
    public function eliminar(Request $request)
    {
        $productoId = $request->input('producto_id');

        $carrito = Session::get('carrito', []);

        if (isset($carrito[$productoId])) {
            unset($carrito[$productoId]);
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

        // Calcular el total del pedido
        $totalPedido = 0;
        foreach ($carrito as $id => $item) {
            $totalPedido += ($item['precio'] * $item['cantidad']);
        }

        // Iniciar una transacción de base de datos para asegurar la atomicidad
        DB::beginTransaction();
        try {
            // Crear el pedido
            $pedido = Pedido::create([
                'user_id' => Auth::id(), // Asigna el ID del usuario autenticado
                'total' => $totalPedido,
                'estado_pedido' => 'pendiente', // Estado inicial del pedido
                'estado_pago' => 'pendiente',   // Estado inicial del pago
                'tipo_entrega' => $request->input('tipo_entrega', 'recoger_local'), // Obtener del request o default
                'direccion_entrega' => $request->input('direccion_entrega'), // Obtener del request
                'telefono_contacto' => $request->input('telefono_contacto'), // Obtener del request
            ]);

            // Añadir los productos al detalle del pedido
            foreach ($carrito as $id => $item) {
                // Asegúrate de que el producto existe antes de intentar guardarlo
                $producto = Producto::find($id);
                if (!$producto) {
                    throw new \Exception("Producto con ID $id no encontrado al procesar el checkout.");
                }

                // Calcular el subtotal para cada item del pedido
                $subtotalItem = $item['precio'] * $item['cantidad'];

                // Adjuntar el producto al pedido con sus detalles
                // Asegúrate de que tu modelo Pedido tiene una relación belongsToMany con Producto
                // y que la tabla pivote es 'detalle_pedidos'
                $pedido->productos()->attach($id, [
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $subtotalItem, // Aseguramos que subtotal se guarda
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Opcional: Actualizar el stock del producto
                $producto->decrement('stock', $item['cantidad']);
            }

            // Limpiar el carrito de la sesión
            Session::forget('carrito');

            DB::commit(); // Confirmar la transacción

            return redirect()->route('checkout.confirm', $pedido->id)->with('success', 'Pedido realizado con éxito. Por favor, sube tu comprobante de pago.');

        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error
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
        // Añadir validación para los campos de entrega
        $rules = [
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif,pdf,svg|max:2048', // Permitir PDF y SVG
            'tipo_entrega' => 'required|in:recoger_local,domicilio',
        ];

        if ($request->input('tipo_entrega') === 'domicilio') {
            $rules['direccion_entrega'] = 'required|string|max:255';
            $rules['telefono_contacto'] = 'required|string|max:20';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            // Actualizar los detalles del pedido
            $pedido->update([
                'tipo_entrega' => $request->input('tipo_entrega'),
                'direccion_entrega' => $request->input('direccion_entrega'),
                'telefono_contacto' => $request->input('telefono_contacto'),
            ]);

            if ($request->hasFile('proof_image')) {
                $imagePath = $request->file('proof_image')->store('proofs', 'public');
                $pedido->update([
                    'comprobante_url' => $imagePath,
                    'estado_pago' => 'pendiente_revision', // Nuevo estado para pago subido
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
