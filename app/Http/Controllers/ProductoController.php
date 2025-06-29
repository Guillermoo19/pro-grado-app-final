<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage; // Importar la fachada Storage

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Producto::class);
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Producto::class);
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Producto::class);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación de imagen
        ]);

        $data = $request->all();

        // Manejo de la subida de imagen
        if ($request->hasFile('imagen')) {
            // Guarda en storage/app/public/productos y obtiene la ruta relativa al disco 'public'
            $imagePath = $request->file('imagen')->store('productos', 'public'); 
            // Guarda SOLO la ruta relativa (ej. productos/nombre_hash.jpg)
            $data['imagen'] = $imagePath; 
        }

        Producto::create($data);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        Gate::authorize('view', $producto);
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        Gate::authorize('update', $producto);
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        Gate::authorize('update', $producto);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validación de imagen
        ]);

        $data = $request->all();

        // Manejo de la actualización de imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen antigua si existe
            // Usar Storage::disk('public')->delete() con la ruta relativa
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }

            // Guarda la nueva imagen y obtiene la ruta relativa
            $imagePath = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $imagePath; // Guarda SOLO la ruta relativa
        }

        $producto->update($data);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        Gate::authorize('delete', $producto);

        // Eliminar imagen asociada si existe
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }
        
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Muestra el catálogo de productos para los clientes.
     */
    public function catalogo()
    {
        $productos = Producto::all(); 
        return view('productos.catalogo', compact('productos'));
    }
}
