<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AdminController; // Asegúrate de que este controlador exista si lo usas

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta para la página de inicio.
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

// Rutas públicas del catálogo y detalles de productos
// La ruta '/productos' ahora es el catálogo público.
Route::get('/productos', [ProductoController::class, 'catalogo'])->name('productos.index'); // Catálogo público
Route::get('/productos/ver/{producto}', [ProductoController::class, 'showPublic'])->name('productos.showPublic'); // Detalles de producto público

// Rutas para el Carrito de Compras (públicas)
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/add', [CarritoController::class, 'add'])->name('carrito.add'); // Usado desde showPublic
Route::post('/carrito/update', [CarritoController::class, 'update'])->name('carrito.update');
Route::post('/carrito/remove', [CarritoController::class, 'remove'])->name('carrito.remove');
Route::post('/carrito/checkout', [CarritoController::class, 'checkout'])->name('carrito.checkout');


// Ruta de inicio (si la usas, considera si es necesaria con 'welcome')
Route::get('/inicio', function () {
    return view('inicio');
});

require __DIR__.'/auth.php';

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para el historial de pedidos del usuario (cliente)
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');

    // Rutas de Checkout (ahora apuntando a CarritoController)
    Route::get('/checkout/confirm/{pedido}', [CarritoController::class, 'confirmPayment'])->name('checkout.confirm');
    Route::post('/checkout/upload-proof/{pedido}', [CarritoController::class, 'uploadPaymentProof'])->name('checkout.upload_proof');


    // Ruta TEMPORAL para probar las relaciones Producto-Ingrediente
    Route::get('/test-relaciones', function() {
        $productoId = 1;
        $ingredienteId = 1;
        $output = '';
        try {
            $producto = App\Models\Producto::find($productoId);
            $ingrediente = App\Models\Ingrediente::find($ingredienteId);
            if ($producto && $ingrediente) {
                if (!$producto->ingredientes()->where('ingrediente_id', $ingrediente->id)->exists()) {
                    $producto->ingredientes()->attach($ingrediente->id, ['cantidad' => 100, 'unidad_medida' => 'gramos']);
                    $output .= "Ingrediente '{$ingrediente->nombre}' adjuntado a Producto '{$producto->nombre}'.<br>";
                } else {
                    $output .= "Ingrediente '{$ingrediente->nombre}' ya está adjunto a Producto '{$producto->nombre}'.<br>";
                }
                $productoConIngredientes = App\Models\Producto::with('ingredientes')->find($productoId);
                if ($productoConIngredientes) {
                    $output .= "<h3>Ingredientes para {$productoConIngredientes->nombre}:</h3>";
                    if ($productoConIngredientes->ingredientes->isEmpty()) {
                        $output .= "No hay ingredientes adjuntos.<br>";
                    } else {
                        foreach ($productoConIngredientes->ingredientes as $ingr) {
                            $output .= " - Ingrediente: " . $ingr->nombre . " (ID: {$ingr->id})<br>";
                            $output .= "   Cantidad: " . $ingr->pivot->cantidad . " " . $ingr->pivot->unidad_medida . "<br>";
                        }
                    }
                } else {
                    $output .= "Producto con ID {$productoId} no encontrado.<br>";
                }
            } else {
                $output .= "Asegúrate de que los IDs de producto ({$productoId}) e ingrediente ({$ingredienteId}) existan.<br>";
            }
        } catch (\Exception $e) {
            $output .= "<h2>¡Error!</h2>";
            $output .= "Mensaje: " . $e->getMessage() . "<br>";
            $output .= "Archivo: " . $e->getFile() . " en línea " . $e->getLine() . "<br>";
        }
        return $output;
    })->name('test.relaciones');
});


// Rutas de administración (protegidas por middleware 'auth' y 'admin')
// Asegúrate de que tienes un middleware 'admin' registrado en Kernel.php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard (descomentar si tienes un AdminController)
    // Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Gestión de Roles, Categorías, Ingredientes
    Route::resource('roles', RoleController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('ingredientes', IngredienteController::class);

    // Gestión de Productos para el ADMIN (CRUD completo)
    // Esto generará rutas con nombres como 'admin.productos.index', 'admin.productos.create', etc.
    Route::resource('productos', ProductoController::class);

    // Gestión de Usuarios (descomentar si tienes un UserController)
    // Route::resource('users', UserController::class)->except(['show']);
    // Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    // Gestión de Pedidos (para administradores)
    Route::get('/pedidos', [PedidoController::class, 'adminIndex'])->name('pedidos.index'); // Admin listado de pedidos
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'adminShow'])->name('pedidos.show'); // Admin ver detalles de pedido
    // Rutas para actualizar estado de pedido y pago (descomentar si las necesitas)
    // Route::put('/pedidos/{pedido}/update-status', [PedidoController::class, 'updateStatus'])->name('pedidos.updateStatus');
    // Route::put('/pedidos/{pedido}/update-payment-status', [PedidoController::class, 'updatePaymentStatus'])->name('pedidos.updatePaymentStatus');
});
