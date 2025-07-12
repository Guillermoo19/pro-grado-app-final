<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de que esta línea esté presente

class CategoriaController extends Controller
{
    // Constructor para aplicar políticas (opcional, como en otros controladores)
    // Puedes dejarlo comentado como está si prefieres autorizar método por método
    public function __construct()
    {
        // $this->middleware('can:viewAny,App\Models\Categoria')->only('index');
        // $this->middleware('can:create,App\Models\Categoria')->only('create', 'store');
        // $this->middleware('can:update,categoria')->only('edit', 'update');
        // $this->middleware('can:delete,categoria')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Categoria::class); // <-- AÑADE ESTA LÍNEA

        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Categoria::class); // <-- AÑADE ESTA LÍNEA

        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Categoria::class); // <-- AÑADE ESTA LÍNEA

        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
        ],
        [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Este nombre de categoría ya existe.',
            'nombre.max' => 'El nombre de la categoría no debe exceder los 255 caracteres.',
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        // CORREGIDO: Redirige a la ruta de administración
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        $this->authorize('view', $categoria); // <-- AÑADE ESTA LÍNEA

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        $this->authorize('update', $categoria); // <-- AÑADE ESTA LÍNEA

        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $this->authorize('update', $categoria); // <-- AÑADE ESTA LÍNEA

        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
        ],
        [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Este nombre de categoría ya existe.',
            'nombre.max' => 'El nombre de la categoría no debe exceder los 255 caracteres.',
        ]);

        $categoria->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        // CORREGIDO: Redirige a la ruta de administración
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $this->authorize('delete', $categoria); // <-- AÑADE ESTA LÍNEA

        $categoria->delete();

        // CORREGIDO: Redirige a la ruta de administración
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
