<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria; // Asegúrate de importar la clase Categoria
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    /**
     * Muestra el catálogo de productos para el público, agrupados por categoría.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtiene todas las categorías y carga sus productos relacionados.
        // Esto evita múltiples consultas a la base de datos (problema de N+1)
        $categorias = Categoria::with('productos')->orderBy('nombre')->get();

        Log::info('ProductoController@index: Catálogo de productos público accedido por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));

        // Pasa la colección de categorías a la vista
        return view('productos.index', compact('categorias'));
    }

    /**
     * Muestra los detalles de un producto específico para el público.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function show(Producto $producto)
    {
        $producto->load('ingredientes');
        $ingredientes = Ingrediente::all();

        Log::info('ProductoController@show: Detalles de producto público accedidos para ID: ' . $producto->id . ' por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));

        return view('productos.show', compact('producto', 'ingredientes'));
    }
}
