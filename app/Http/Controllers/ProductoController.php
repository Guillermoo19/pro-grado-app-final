<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    /**
     * Constructor para aplicar políticas a los métodos del controlador.
     */
    public function __construct()
    {
        $this->middleware('can:create,App\Models\Producto')->only('create', 'store');
        $this->middleware('can:update,producto')->only('edit', 'update');
        $this->middleware('can:delete,producto')->only('destroy');
    }

    /**
     * Muestra el catálogo de productos para el público.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $productos = Producto::with('categoria')->orderBy('nombre')->get();
        Log::info('ProductoController@index: Catálogo de productos público accedido por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return view('productos.index', compact('productos')); // Vista pública
    }

    /**
     * Muestra la lista de productos para el panel de administración.
     *
     * @return \Illuminate\View\View
     */
    public function adminIndex()
    {
        $this->authorize('viewAny', Producto::class);

        $productos = Producto::with('categoria')->orderBy('nombre')->get();
        Log::info('ProductoController@adminIndex: Lista de productos para administración accedida por ' . Auth::user()->email);
        return view('admin.productos.index', compact('productos')); // Vista de administración
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
        Log::info('ProductoController@show: Detalles de producto público accedidos para ID: ' . $producto->id . ' por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return view('productos.show', compact('producto')); // Vista pública de detalles
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     * Solo accesible para administradores (controlado por la política).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Producto::class);
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        Log::info('ProductoController@create: Formulario de creación de producto accedido por ' . Auth::user()->email);
        return view('admin.productos.create', compact('categorias', 'ingredientes'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     * Solo accesible para administradores (controlado por la política).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Producto::class);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ingredientes' => 'array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ],
        [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.regex' => 'El precio debe tener como máximo dos decimales.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'imagen.required' => 'La imagen del producto es obligatoria.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg.',
            'imagen.max' => 'La imagen no debe exceder los 2MB.',
            'ingredientes.array' => 'Los ingredientes deben ser un formato de lista.',
            'ingredientes.*.exists' => 'Alguno de los ingredientes seleccionados no es válido.',
        ]);

        $productoData = $request->except('ingredientes');

        if ($request->hasFile('imagen')) {
            $productoData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($productoData);

        // --- CAMBIO CLAVE AQUÍ: Preparar datos para la tabla pivote ---
        if ($request->has('ingredientes')) {
            $ingredientesToSync = [];
            foreach ($request->input('ingredientes') as $ingredienteId) {
                $ingredientesToSync[$ingredienteId] = ['cantidad' => 1, 'unidad_medida' => 'unidad']; // Valores predeterminados
            }
            $producto->ingredientes()->sync($ingredientesToSync);
        }
        // --- FIN CAMBIO CLAVE ---

        Log::info('ProductoController@store: Producto ' . $producto->nombre . ' creado exitosamente por ' . Auth::user()->email . '. ID: ' . $producto->id);
        return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     * Solo accesible para administradores (controlado por la política).
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function edit(Producto $producto)
    {
        $this->authorize('update', $producto);
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        $producto->load('ingredientes');
        Log::info('ProductoController@edit: Formulario de edición de producto accedido para ID: ' . $producto->id . ' por ' . Auth::user()->email);
        return view('admin.productos.edit', compact('producto', 'categorias', 'ingredientes'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     * Solo accesible para administradores (controlado por la política).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Producto $producto)
    {
        $this->authorize('update', $producto);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ingredientes' => 'array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ],
        [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.regex' => 'El precio debe tener como máximo dos decimales.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg.',
            'imagen.max' => 'La imagen no debe exceder los 2MB.',
            'ingredientes.array' => 'Los ingredientes deben ser un formato de lista.',
            'ingredientes.*.exists' => 'Alguno de los ingredientes seleccionados no es válido.',
        ]);

        $productoData = $request->except('ingredientes');

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $productoData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($productoData);

        // --- CAMBIO CLAVE AQUÍ: Preparar datos para la tabla pivote ---
        if ($request->has('ingredientes')) {
            $ingredientesToSync = [];
            foreach ($request->input('ingredientes') as $ingredienteId) {
                $ingredientesToSync[$ingredienteId] = ['cantidad' => 1, 'unidad_medida' => 'unidad']; // Valores predeterminados
            }
            $producto->ingredientes()->sync($ingredientesToSync);
        } else {
            // Si no se seleccionan ingredientes, desvincular todos los existentes
            $producto->ingredientes()->detach();
        }
        // --- FIN CAMBIO CLAVE ---

        Log::info('ProductoController@update: Producto ' . $producto->nombre . ' actualizado exitosamente por ' . Auth::user()->email . '. ID: ' . $producto->id);
        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     * Solo accesible para administradores (controlado por la política).
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();
        Log::info('ProductoController@destroy: Producto ' . $producto->nombre . ' eliminado por ' . Auth::user()->email . '. ID: ' . $producto->id);
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
