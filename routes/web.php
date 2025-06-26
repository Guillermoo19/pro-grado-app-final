<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\IngredienteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas para la página de inicio.
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/inicio', function () {
    return view('inicio');
});

// Rutas de autenticación de Laravel Breeze (NO LAS TOQUES - Vienen de auth.php)
require __DIR__.'/auth.php';

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Rutas del Dashboard de Breeze
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de Perfil de Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // TUS RUTAS DE CRUD PERSONALIZADAS AQUI
    // Rutas para Roles (protegidas por Auth y luego por Política)
    Route::resource('roles', RoleController::class);

    // Rutas para Categorías (protegidas por Auth y luego por Política)
    Route::resource('categorias', CategoriaController::class);

    // Rutas para Productos (protegidas por Auth y luego por Política)
    Route::resource('productos', ProductoController::class);

    // Rutas para Ingredientes (Añade esta línea, protegidas por Auth y luego por Política)
    Route::resource('ingredientes', IngredienteController::class); // <-- ¡AÑADE ESTA LÍNEA!

    // Ruta TEMPORAL para probar las relaciones Producto-Ingrediente
    Route::get('/test-relaciones', function() {
        $productoId = 1; // REEMPLAZA con el ID de un Producto existente (ej. 1 si es tu primer producto)
        $ingredienteId = 1; // REEMPLAZA con el ID de un Ingrediente existente (ej. 1 si es tu primer ingrediente)

        $output = '';

        try {
            $producto = App\Models\Producto::find($productoId);
            $ingrediente = App\Models\Ingrediente::find($ingredienteId);

            if ($producto && $ingrediente) {
                // Adjuntar si no está ya adjunto (para evitar duplicados en cada carga de página)
                if (!$producto->ingredientes()->where('ingrediente_id', $ingrediente->id)->exists()) {
                    $producto->ingredientes()->attach($ingrediente->id, ['cantidad' => 100, 'unidad_medida' => 'gramos']);
                    $output .= "Ingrediente '{$ingrediente->nombre}' adjuntado a Producto '{$producto->nombre}'.<br>";
                } else {
                    $output .= "Ingrediente '{$ingrediente->nombre}' ya está adjunto a Producto '{$producto->nombre}'.<br>";
                }

                // Recuperar los ingredientes del producto
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

    // Puedes añadir más rutas protegidas aquí si las necesitas
});
