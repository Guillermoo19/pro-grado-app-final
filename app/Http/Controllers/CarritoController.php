<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Importar la fachada DB para transacciones

class CarritoController extends Controller
{
    /**
     * Muestra el contenido del carrito de compras.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('carrito.index', compact('cart'));
    }

    /**
     * Añade un producto al carrito.
     */
    public function add(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $cantidad = $request->cantidad ?: 1; // Cantidad por defecto es 1 si no se especifica

        $cart = session()->get('cart', []);

        // Si el producto ya está en el carrito, incrementa la cantidad
        if (isset($cart[$producto->id])) {
            $cart[$producto->id]['cantidad'] += $cantidad;
        } else {
            // Si no, añade el producto con sus detalles
            $cart[$producto->id] = [
                "id" => $producto->id, // Guardar el ID del producto
                "nombre" => $producto->nombre,
                "descripcion" => $producto->descripcion,
                "cantidad" => $cantidad,
                "precio" => $producto->precio,
                "imagen" => $producto->imagen // Incluir la imagen
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Producto añadido al carrito.');
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     */
    public function update(Request $request)
    {
        if ($request->id && $request->cantidad) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                if ($request->cantidad > 0) {
                    $producto = Producto::findOrFail($request->id);
                    // No permitir que la cantidad en el carrito exceda el stock disponible
                    if ($request->cantidad > $producto->stock) {
                        return redirect()->back()->with('error', 'No hay suficiente stock para la cantidad solicitada de ' . $producto->nombre . '. Stock disponible: ' . $producto->stock);
                    }
                    $cart[$request->id]['cantidad'] = $request->cantidad;
                    session()->put('cart', $cart);
                    return redirect()->back()->with('success', 'Cantidad del producto actualizada.');
                } else {
                    // Si la cantidad es 0 o menos, eliminar el producto del carrito
                    return redirect()->route('carrito.remove', ['id' => $request->id]);
                }
            }
        }
        return redirect()->back()->with('error', 'Error al actualizar la cantidad del producto.');
    }

    /**
     * Elimina un producto del carrito.
     */
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Producto eliminado del carrito.');
            }
        }
        return redirect()->back()->with('error', 'Error al eliminar el producto del carrito.');
    }

    /**
     * Procesa el checkout del carrito y crea un pedido.
     */
    public function checkout(Request $request)
    {
        // Asegúrate de que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para proceder al pago.');
        }

        $cart = session()->get('cart');

        if (empty($cart)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío, no se puede realizar el pago.');
        }

        // Usar una transacción de base de datos para asegurar la atomicidad
        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $detallePedidos = []; // Array para almacenar los detalles del pedido a crear

            foreach ($cart as $id => $item) {
                $producto = Producto::find($id);

                // Verificar si el producto aún existe y si hay suficiente stock
                if (!$producto || $producto->stock < $item['cantidad']) {
                    DB::rollBack();
                    $productName = $producto ? $producto->nombre : 'Un producto';
                    $availableStock = $producto ? $producto->stock : 0;
                    return redirect()->route('carrito.index')->with('error', 'No hay suficiente stock para "' . $productName . '". Stock disponible: ' . $availableStock . '. Por favor, ajusta tu carrito.');
                }

                $subtotal = $item['precio'] * $item['cantidad'];
                $totalAmount += $subtotal;

                // Restar del stock del producto
                $producto->stock -= $item['cantidad'];
                $producto->save();

                // Preparar los detalles para el pedido
                $detallePedidos[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Crear el nuevo pedido
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'order_date' => now(),
                'total_amount' => $totalAmount,
                'status' => 'pendiente', // O 'completado' si integras pasarela de pago real
            ]);

            // Guardar los detalles del pedido
            $pedido->detallePedidos()->createMany($detallePedidos);

            // Vaciar el carrito de la sesión
            session()->forget('cart');

            DB::commit(); // Confirmar la transacción

            return view('checkout.confirmacion', compact('pedido'))->with('success', 'Tu pedido ha sido realizado con éxito.');

        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error
            // Logear el error para depuración
            \Log::error('Error al procesar el checkout: ' . $e->getMessage());
            return redirect()->route('carrito.index')->with('error', 'Hubo un error al procesar tu pedido. Por favor, intenta de nuevo.');
        }
    }
}
