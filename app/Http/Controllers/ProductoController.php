<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log; // Asegúrate de importar Log

class ProductoController extends Controller
{
    /**
     * Muestra una lista de todos los productos (para administración).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $productos = Producto::with('categoria')->orderBy('nombre')->get();
        Log::info('ProductoController@index: Lista de productos para administración accedida.');
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el catálogo de productos para el público.
     *
     * @return \Illuminate\View\View
     */
    public function catalogo()
    {
        $productos = Producto::with('categoria')->orderBy('nombre')->get();
        Log::info('ProductoController@catalogo: Catálogo accedido.');
        // CAMBIO CLAVE: Renderiza la vista 'productos.index' para el catálogo público
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra los detalles de un producto específico para el público.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function showPublic(Producto $producto)
    {
        $producto->load('ingredientes'); // Cargar los ingredientes relacionados
        Log::info('ProductoController@showPublic: Detalles de producto público accedidos para ID: ' . $producto->id);
        // CAMBIO CLAVE: Renderiza la vista 'productos.show' para los detalles públicos
        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        Log::info('ProductoController@create: Formulario de creación de producto accedido.');
        return view('productos.create', compact('categorias', 'ingredientes'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ingredientes' => 'array', // Debe ser un array de IDs de ingredientes
            'ingredientes.*' => 'exists:ingredientes,id', // Cada ID debe existir en la tabla ingredientes
        ]);

        $productoData = $request->except('ingredientes'); // Excluir ingredientes para la creación inicial

        if ($request->hasFile('imagen')) {
            $productoData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($productoData);

        // Sincronizar ingredientes si se proporcionaron
        if ($request->has('ingredientes')) {
            $producto->ingredientes()->sync($request->input('ingredientes'));
        }

        Log::info('ProductoController@store: Producto ' . $producto->nombre . ' creado exitosamente. ID: ' . $producto->id);
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra los detalles de un producto específico (para administración).
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function show(Producto $producto)
    {
        $producto->load('categoria', 'ingredientes');
        Log::info('ProductoController@show: Detalles de producto para administración accedidos para ID: ' . $producto->id);
        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para editar un producto existente.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        $producto->load('ingredientes'); // Cargar ingredientes relacionados para el formulario de edición
        Log::info('ProductoController@edit: Formulario de edición de producto accedido para ID: ' . $producto->id);
        return view('productos.edit', compact('producto', 'categorias', 'ingredientes'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ingredientes' => 'array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ]);

        $productoData = $request->except('ingredientes');

        if ($request->hasFile('imagen')) {
            // Eliminar imagen antigua si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $productoData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($productoData);

        // Sincronizar ingredientes
        $producto->ingredientes()->sync($request->input('ingredientes', [])); // Si no hay ingredientes, pasa un array vacío

        Log::info('ProductoController@update: Producto ' . $producto->nombre . ' actualizado exitosamente. ID: ' . $producto->id);
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Producto $producto)
    {
        // Eliminar imagen asociada si existe
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();
        Log::info('ProductoController@destroy: Producto ' . $producto->nombre . ' eliminado. ID: ' . $producto->id);
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
