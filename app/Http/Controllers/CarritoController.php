<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Pedido; // Asegúrate de que esta línea esté presente
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Importar Storage para guardar archivos

class CarritoController extends Controller
{
    /**
     * Muestra el contenido del carrito de compras.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $carrito = Session::get('carrito', []);
        $productosEnCarrito = [];
        $totalCarrito = 0;

        foreach ($carrito as $id => $cantidad) {
            $producto = Producto::find($id);
            if ($producto) {
                $subtotal = $producto->precio * $cantidad;
                $productosEnCarrito[] = [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                ];
                $totalCarrito += $subtotal;
            }
        }

        Log::info('CarritoController@index: Carrito mostrado al usuario ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return view('carrito.index', compact('productosEnCarrito', 'totalCarrito'));
    }

    /**
     * Agrega un producto al carrito.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function agregar(Request $request, Producto $producto)
    {
        $cantidad = $request->input('cantidad', 1);
        $carrito = Session::get('carrito', []);

        if (isset($carrito[$producto->id])) {
            $carrito[$producto->id] += $cantidad;
        } else {
            $carrito[$producto->id] = $cantidad;
        }

        Session::put('carrito', $carrito);
        Log::info('CarritoController@agregar: Producto ' . $producto->nombre . ' agregado al carrito. Cantidad: ' . $cantidad . '. Usuario: ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actualizar(Request $request, Producto $producto)
    {
        $cantidad = $request->input('cantidad');
        $carrito = Session::get('carrito', []);

        if (isset($carrito[$producto->id])) {
            if ($cantidad <= 0) {
                unset($carrito[$producto->id]);
                Log::info('CarritoController@actualizar: Producto ' . $producto->nombre . ' eliminado del carrito por cantidad 0. Usuario: ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
            } else {
                $carrito[$producto->id] = $cantidad;
                Log::info('CarritoController@actualizar: Cantidad de producto ' . $producto->nombre . ' actualizada a ' . $cantidad . '. Usuario: ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
            }
            Session::put('carrito', $carrito);
            return redirect()->route('carrito.index')->with('success', 'Carrito actualizado.');
        }

        return redirect()->route('carrito.index')->with('error', 'Producto no encontrado en el carrito.');
    }

    /**
     * Elimina un producto del carrito.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminar(Producto $producto)
    {
        $carrito = Session::get('carrito', []);

        if (isset($carrito[$producto->id])) {
            unset($carrito[$producto->id]);
            Session::put('carrito', $carrito);
            Log::info('CarritoController@eliminar: Producto ' . $producto->nombre . ' eliminado del carrito. Usuario: ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
            return redirect()->route('carrito.index')->with('success', 'Producto eliminado del carrito.');
        }

        return redirect()->route('carrito.index')->with('error', 'Producto no encontrado en el carrito.');
    }

    /**
     * Procede al checkout, creando un pedido y vaciando el carrito.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para proceder al pago.');
        }

        $carrito = Session::get('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        $total = 0;
        foreach ($carrito as $id => $cantidad) {
            $producto = Producto::find($id);
            if ($producto) {
                $total += $producto->precio * $cantidad;
            }
        }

        // Crear el pedido principal
        $pedido = Pedido::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'estado' => 'pendiente', // Estado inicial del pedido
            'estado_pago' => 'pendiente', // Estado inicial del pago
        ]);

        // Guardar los detalles del pedido
        foreach ($carrito as $id => $cantidad) {
            $producto = Producto::find($id);
            if ($producto) {
                $pedido->productos()->attach($producto->id, [
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $producto->precio * $cantidad,
                ]);
            }
        }

        Session::forget('carrito'); // Vaciar el carrito
        Log::info('CarritoController@checkout: Pedido ID: ' . $pedido->id . ' creado por usuario ' . Auth::user()->email . '. Total: ' . $total);

        // Redirigir a la página de confirmación de pago
        return redirect()->route('checkout.confirm', $pedido->id)->with('success', 'Pedido creado exitosamente. Por favor, confirma tu pago.');
    }

    /**
     * Muestra la página de confirmación de pago para un pedido específico.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function confirmPayment(Pedido $pedido)
    {
        // Asegurarse de que el usuario solo pueda confirmar su propio pedido
        if ($pedido->user_id !== Auth::id()) {
            return redirect()->route('pedidos.index')->with('error', 'No tienes permiso para confirmar este pedido.');
        }

        // Si el pedido ya tiene un comprobante o está pagado, redirigir
        if ($pedido->estado_pago !== 'pendiente') {
            return redirect()->route('pedidos.show', $pedido->id)->with('info', 'Este pedido ya tiene un estado de pago diferente a "pendiente".');
        }

        $pedido->load('productos'); // Cargar productos para mostrar el resumen del pedido
        Log::info('CarritoController@confirmPayment: Usuario ' . Auth::user()->email . ' ha accedido a la confirmación de pago para el pedido ID: ' . $pedido->id);
        return view('checkout.confirm', compact('pedido'));
    }

    /**
     * Procesa la subida del comprobante de pago para un pedido.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadPaymentProof(Request $request, Pedido $pedido)
    {
        // Asegurarse de que el usuario solo pueda subir comprobante para su propio pedido
        if ($pedido->user_id !== Auth::id()) {
            return redirect()->route('pedidos.index')->with('error', 'No tienes permiso para subir un comprobante para este pedido.');
        }

        // Validar la subida del archivo
        $request->validate([
            'comprobante' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB
        ]);

        // Guardar la imagen en el almacenamiento público
        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('comprobantes', 'public');

            // Actualizar el pedido con la URL del comprobante y cambiar el estado de pago
            $pedido->update([
                'comprobante_imagen_url' => $path,
                'estado_pago' => 'subido', // Nuevo estado: 'subido' o 'en_revision'
            ]);

            Log::info('CarritoController@uploadPaymentProof: Comprobante subido para pedido ID: ' . $pedido->id . ' por usuario ' . Auth::user()->email . '. URL: ' . $path);
            return redirect()->route('pedidos.show', $pedido->id)->with('success', 'Comprobante de pago subido exitosamente. Tu pedido está ahora en revisión.');
        }

        return back()->with('error', 'No se pudo subir el comprobante de pago. Inténtalo de nuevo.');
    }
}
