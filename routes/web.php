<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController; // Asegúrate de que esté importado

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

// Rutas para la página de inicio.
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// Ruta pública para el catálogo de productos de la tienda
Route::get('/productos/catalogo', [ProductoController::class, 'catalogo'])->name('productos.catalogo');

// Rutas para el Carrito de Compras (públicas)
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/add', [CarritoController::class, 'add'])->name('carrito.add');
Route::post('/carrito/update', [CarritoController::class, 'update'])->name('carrito.update');
Route::post('/carrito/remove', [CarritoController::class, 'remove'])->name('carrito.remove');
Route::post('/carrito/checkout', [CarritoController::class, 'checkout'])->name('carrito.checkout');


Route::get('/inicio', function () {
    return view('inicio');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('ingredientes', IngredienteController::class);

    // Rutas para el historial de pedidos del usuario (cliente)
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');

    // ************************************************
    // NUEVA RUTA: Panel de administración de pedidos (solo para administradores)
    // ************************************************
    Route::get('/admin/pedidos', [PedidoController::class, 'adminIndex'])->name('pedidos.admin_index');
    // ************************************************

    // Ruta TEMPORAL para probar las relaciones Producto-Ingrediente
    Route::get('/test-relaciones', function() {
        $productoId = 1; // REEMPLAZA con el ID de un Producto existente (ej. 1 si es tu primer producto)
        $ingredienteId = 1; // REEMPLAZA con el ID de un Ingrediente existente (ej. 1 si es tu primer ingrediente)

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
