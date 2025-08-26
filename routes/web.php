<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');

// Rutas del Carrito (accesibles para invitados)
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/add', [CarritoController::class, 'agregar'])->name('carrito.add');
Route::post('/carrito/update', [CarritoController::class, 'actualizar'])->name('carrito.update');
Route::post('/carrito/remove', [CarritoController::class, 'eliminar'])->name('carrito.remove');


// Rutas que SÍ requieren autenticación (login)
Route::middleware('auth')->group(function () {
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Checkout (requieren autenticación)
    Route::post('/carrito/checkout', [CarritoController::class, 'checkout'])->name('carrito.checkout');
    Route::get('/checkout/confirm/{pedido}', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout/upload-proof/{pedido}', [CheckoutController::class, 'uploadProof'])->name('checkout.upload_proof');

    // Rutas de Pedidos para el cliente (Mis Pedidos)
    Route::get('/mis-pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/mis-pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');


    // Rutas de Administración (Solo para usuarios con rol 'admin')
    Route::middleware(['can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard de Administración
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Rutas para Productos (Admin)
        Route::resource('productos', AdminProductoController::class);
        
        // Rutas para Roles (Admin)
        Route::resource('roles', RoleController::class);
        
        // Rutas para Categorías (Admin)
        Route::resource('categorias', CategoriaController::class);

        // Rutas para Ingredientes (Admin)
        Route::resource('ingredientes', IngredienteController::class);

        // Rutas para Pedidos (Admin)
        Route::get('/pedidos', [PedidoController::class, 'adminIndex'])->name('pedidos.index');
        Route::get('/pedidos/{pedido}', [PedidoController::class, 'adminShow'])->name('pedidos.show');
        Route::patch('/pedidos/{pedido}/update-estado-pedido', [PedidoController::class, 'updateEstadoPedido'])->name('pedidos.update_estado_pedido');
        Route::patch('/pedidos/{pedido}/update-estado-pago', [PedidoController::class, 'updateEstadoPago'])->name('pedidos.update_estado_pago');

        // Rutas para Usuarios (Admin)
        Route::resource('users', UserController::class); 
        Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update_role');
        Route::patch('users/{user}/demote', [UserController::class, 'demoteAdmin'])->name('users.demote');


        // Rutas para la Configuración del Establecimiento
        Route::get('/configuracion', [ConfiguracionController::class, 'edit'])->name('configuracion.edit');
        Route::put('/configuracion', [ConfiguracionController::class, 'update'])->name('configuracion.update');
    });
});

// Incluye las rutas de autenticación de Breeze
require __DIR__.'/auth.php';
