<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
     * Constructor para aplicar políticas de autorización.
     */
    public function __construct()
    {
        $this->middleware('can:create,App\Models\Producto')->only('create', 'store');
        $this->middleware('can:update,producto')->only('edit', 'update');
        $this->middleware('can:delete,producto')->only('destroy');
    }

    /**
     * Muestra la lista de productos para el panel de administración.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', Producto::class);
        $productos = Producto::with('categoria')->orderBy('nombre')->get();
        Log::info('Admin\ProductoController@index: Lista de productos para administración accedida por ' . Auth::user()->email);
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Producto::class);
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();
        Log::info('Admin\ProductoController@create: Formulario de creación de producto accedido por ' . Auth::user()->email);
        return view('admin.productos.create', compact('categorias', 'ingredientes'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Producto::class);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'descripcion' => 'nullable|string',
            'precio' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ingredientes' => 'array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique' => 'Ya existe un producto con este nombre.',
            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.regex' => 'El precio debe tener como máximo dos decimales.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg.',
            'imagen.max' => 'La imagen no debe exceder los 2MB.',
            'ingredientes.array' => 'Los ingredientes deben ser un formato de lista.',
            'ingredientes.*.exists' => 'Alguno de los ingredientes seleccionados no es válido.',
        ]);

        $productoData = $request->except(['imagen', 'ingredientes']);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $productoData['imagen'] = $path;
        } else {
            $productoData['imagen'] = 'productos/default.jpg';
        }
        
        $producto = Producto::create($productoData);

        if ($request->has('ingredientes')) {
            $ingredientesToSync = [];
            foreach ($request->input('ingredientes') as $ingredienteId) {
                $ingredientesToSync[$ingredienteId] = ['cantidad' => 1, 'unidad_medida' => 'unidad'];
            }
            $producto->ingredientes()->sync($ingredientesToSync);
        }
        
        Log::info('Admin\ProductoController@store: Producto ' . $producto->nombre . ' creado exitosamente por ' . Auth::user()->email . '. ID: ' . $producto->id);
        return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
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
        Log::info('Admin\ProductoController@edit: Formulario de edición de producto accedido para ID: ' . $producto->id . ' por ' . Auth::user()->email);
        return view('admin.productos.edit', compact('producto', 'categorias', 'ingredientes'));
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
        $this->authorize('update', $producto);

        $request->validate([
            'nombre' => ['required', 'string', 'max:255', Rule::unique('productos', 'nombre')->ignore($producto->id)],
            'descripcion' => 'nullable|string',
            'precio' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            // Se elimina la validación del campo 'stock'
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ingredientes' => 'array',
            'ingredientes.*' => 'exists:ingredientes,id',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique' => 'Ya existe un producto con este nombre.',
            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.regex' => 'El precio debe tener como máximo dos decimales.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, gif o svg.',
            'imagen.max' => 'La imagen no debe exceder los 2MB.',
            'ingredientes.array' => 'Los ingredientes deben ser un formato de lista.',
            'ingredientes.*.exists' => 'Alguno de los ingredientes seleccionados no es válido.',
        ]);

        $productoData = $request->except(['imagen', 'ingredientes']);
        
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si no es la por defecto
            if ($producto->imagen && $producto->imagen !== 'productos/default.jpg') {
                Storage::disk('public')->delete($producto->imagen);
            }
            // Guardar la nueva imagen
            $path = $request->file('imagen')->store('productos', 'public');
            $productoData['imagen'] = $path;
        }

        $producto->update($productoData);

        if ($request->has('ingredientes')) {
            $ingredientesToSync = [];
            foreach ($request->input('ingredientes') as $ingredienteId) {
                $ingredientesToSync[$ingredienteId] = ['cantidad' => 1, 'unidad_medida' => 'unidad'];
            }
            $producto->ingredientes()->sync($ingredientesToSync);
        } else {
            $producto->ingredientes()->detach();
        }

        Log::info('Admin\ProductoController@update: Producto ' . $producto->nombre . ' actualizado exitosamente por ' . Auth::user()->email . '. ID: ' . $producto->id);
        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        // Eliminar la imagen asociada si no es la por defecto
        if ($producto->imagen && $producto->imagen !== 'productos/default.jpg') {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->ingredientes()->detach();
        $producto->delete();
        
        Log::info('Admin\ProductoController@destroy: Producto ' . $producto->nombre . ' eliminado por ' . Auth::user()->email . '. ID: ' . $producto->id);
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
