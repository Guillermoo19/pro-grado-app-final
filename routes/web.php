<?php 
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IngredienteController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "web" middleware group. Make something great!
|
*/

// Ruta de la página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas accesibles para TODOS (Invitados y Autenticados)
// Estas rutas NO requieren que el usuario esté logueado
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index'); // Menú
Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show'); // Detalle del Plato

// Rutas del Carrito (accesibles para invitados)
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
// Sincronizar con los nombres de métodos en CarritoController
Route::post('/carrito/add', [CarritoController::class, 'agregar'])->name('carrito.add');
Route::post('/carrito/update', [CarritoController::class, 'actualizar'])->name('carrito.update');
Route::post('/carrito/remove', [CarritoController::class, 'eliminar'])->name('carrito.remove');


// Rutas que SÍ requieren autenticación (login)
Route::middleware('auth')->group(function () {
    // Dashboard (para usuarios normales)
    Route::get('/dashboard', function () {
        return view('dashboard'); // Asume que tienes un dashboard.blade.php para usuarios normales
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Checkout (requieren autenticación)
    Route::post('/carrito/checkout', [CarritoController::class, 'checkout'])->name('carrito.checkout');
    Route::get('/checkout/confirm/{pedidoId}', [CarritoController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout/upload-proof/{pedido}', [CarritoController::class, 'uploadProof'])->name('checkout.upload_proof');

    // Rutas de Pedidos para el cliente (Mis Pedidos)
    Route::get('/mis-pedidos', [PedidoController::class, 'index'])->name('pedidos.index'); // PedidoController@index ahora carga resources/views/pedidos/index.blade.php
    Route::get('/mis-pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show'); // PedidoController@show carga resources/views/pedidos/show.blade.php


    // Rutas de Administración (Solo para usuarios con rol 'admin')
    Route::middleware(['can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard de Administración
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // Asegúrate de que esta es la vista correcta para el admin dashboard
        })->name('dashboard');

        // Rutas para Productos (Admin)
        Route::resource('productos', ProductoController::class); // Estas rutas Resource usarán admin.productos.index, admin.productos.show, etc.
        
        // Rutas para Roles (Admin)
        Route::resource('roles', RoleController::class);
        
        // Rutas para Categorías (Admin)
        Route::resource('categorias', CategoriaController::class);

        // Rutas para Ingredientes (Admin)
        Route::resource('ingredientes', IngredienteController::class);

        // Rutas para Pedidos (Admin) - Nombres de ruta corregidos
        Route::get('/pedidos', [PedidoController::class, 'adminIndex'])->name('pedidos.index'); // Ahora es admin.pedidos.index
        Route::get('/pedidos/{pedido}', [PedidoController::class, 'adminShow'])->name('pedidos.show'); // Ahora es admin.pedidos.show
    });
});

// Incluye las rutas de autenticación de Breeze (login, register, reset password, etc.)
require __DIR__.'/auth.php';
