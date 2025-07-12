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
        // Los métodos 'index' y 'show' ahora son públicos por defecto.
        // Las políticas 'viewAny' y 'view' en ProductoPolicy deben permitir a todos.
        // Solo aplicamos el middleware 'can' a las acciones que requieren ser admin.
        $this->middleware('can:create,App\Models\Producto')->only('create', 'store');
        $this->middleware('can:update,producto')->only('edit', 'update');
        $this->middleware('can:delete,producto')->only('destroy');
    }

    /**
     * Muestra el catálogo de productos para el público y la lista para administración.
     * La vista se adapta según el rol del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // La política viewAny en ProductoPolicy ahora permite a todos ver el listado.
        // No necesitamos $this->authorize('viewAny', Producto::class); aquí si la política devuelve true para todos.
        $productos = Producto::with('categoria')->orderBy('nombre')->get();

        if (Auth::check() && Auth::user()->isAdmin()) {
            Log::info('ProductoController@index: Lista de productos para administración accedida por ' . Auth::user()->email);
        } else {
            Log::info('ProductoController@index: Catálogo de productos público accedido por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        }

        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra los detalles de un producto específico para el público y la administración.
     * La vista se adapta según el rol del usuario.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\View\View
     */
    public function show(Producto $producto)
    {
        // La política 'view' en ProductoPolicy ahora permite a todos ver los detalles.
        // No necesitamos $this->authorize('view', $producto); aquí si la política devuelve true para todos.
        $producto->load('ingredientes');

        if (Auth::check() && Auth::user()->isAdmin()) {
            Log::info('ProductoController@show: Detalles de producto para administración accedidos para ID: ' . $producto->id . ' por ' . Auth::user()->email);
        } else {
            Log::info('ProductoController@show: Detalles de producto público accedidos para ID: ' . $producto->id . ' por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        }

        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     * Solo accesible para administradores (controlado por la política).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Producto::class); // Autoriza crear un producto (solo admins)

        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        Log::info('ProductoController@create: Formulario de creación de producto accedido por ' . Auth::user()->email);
        return view('productos.create', compact('categorias', 'ingredientes'));
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
        $this->authorize('create', Producto::class); // Autoriza crear un producto (solo admins)

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id', // CAMBIO AQUÍ: Ahora es 'required'
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ingredientes' => 'array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ]);

        $productoData = $request->except('ingredientes');

        if ($request->hasFile('imagen')) {
            $productoData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($productoData);

        if ($request->has('ingredientes')) {
            $producto->ingredientes()->sync($request->input('ingredientes'));
        }

        Log::info('ProductoController@store: Producto ' . $producto->nombre . ' creado exitosamente por ' . Auth::user()->email . '. ID: ' . $producto->id);
        return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente.'); // Cambiado a admin.productos.index
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
        $this->authorize('update', $producto); // Autoriza actualizar este producto (solo admins)

        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        $producto->load('ingredientes');
        Log::info('ProductoController@edit: Formulario de edición de producto accedido para ID: ' . $producto->id . ' por ' . Auth::user()->email);
        return view('productos.edit', compact('producto', 'categorias', 'ingredientes'));
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
        $this->authorize('update', $producto); // Autoriza actualizar este producto (solo admins)

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id', // CAMBIO AQUÍ: Ahora es 'required'
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ingredientes' => 'array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ]);

        $productoData = $request->except('ingredientes');

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $productoData['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($productoData);

        $producto->ingredientes()->sync($request->input('ingredientes', []));

        Log::info('ProductoController@update: Producto ' . $producto->nombre . ' actualizado exitosamente por ' . Auth::user()->email . '. ID: ' . $producto->id);
        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado exitosamente.'); // Cambiado a admin.productos.index
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
        $this->authorize('delete', $producto); // Autoriza eliminar este producto (solo admins)

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();
        Log::info('ProductoController@destroy: Producto ' . $producto->nombre . ' eliminado por ' . Auth::user()->email . '. ID: ' . $producto->id);
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado exitosamente.'); // Cambiado a admin.productos.index
    }
}
