<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de que esta línea esté presente

class IngredienteController extends Controller
{
    // Constructor para aplicar políticas (opcional, como en otros controladores)
    public function __construct()
    {
        // Puedes dejarlo comentado si prefieres autorizar método por método
        // $this->middleware('can:viewAny,App\Models\Ingrediente')->only('index');
        // $this->middleware('can:create,App\Models\Ingrediente')->only('create', 'store');
        // $this->middleware('can:update,ingrediente')->only('edit', 'update');
        // $this->middleware('can:delete,ingrediente')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Ingrediente::class); // <-- AÑADE ESTA LÍNEA

        $ingredientes = Ingrediente::all();
        return view('ingredientes.index', compact('ingredientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Ingrediente::class); // <-- AÑADE ESTA LÍNEA

        return view('ingredientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Ingrediente::class); // <-- AÑADE ESTA LÍNEA

        $request->validate([
            'nombre' => 'required|string|max:255|unique:ingredientes,nombre',
            'descripcion' => 'nullable|string',
        ],
        [
            'nombre.required' => 'El nombre del ingrediente es obligatorio.',
            'nombre.unique' => 'Este nombre de ingrediente ya existe.',
            'nombre.max' => 'El nombre del ingrediente no debe exceder los 255 caracteres.',
        ]);

        Ingrediente::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        // CORREGIDO: Redirige a la ruta de administración
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingrediente $ingrediente)
    {
        $this->authorize('view', $ingrediente); // <-- AÑADE ESTA LÍNEA

        abort(404); // O la vista de show si la implementas
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingrediente $ingrediente)
    {
        $this->authorize('update', $ingrediente); // <-- AÑADE ESTA LÍNEA

        return view('ingredientes.edit', compact('ingrediente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingrediente $ingrediente)
    {
        $this->authorize('update', $ingrediente); // <-- AÑADE ESTA LÍNEA

        $request->validate([
            'nombre' => 'required|string|max:255|unique:ingredientes,nombre,' . $ingrediente->id,
            'descripcion' => 'nullable|string',
        ],
        [
            'nombre.required' => 'El nombre del ingrediente es obligatorio.',
            'nombre.unique' => 'Este nombre de ingrediente ya existe.',
            'nombre.max' => 'El nombre del ingrediente no debe exceder los 255 caracteres.',
        ]);

        $ingrediente->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        // CORREGIDO: Redirige a la ruta de administración
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingrediente $ingrediente)
    {
        $this->authorize('delete', $ingrediente); // <-- AÑADE ESTA LÍNEA

        $ingrediente->delete();

        // CORREGIDO: Redirige a la ruta de administración
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente eliminado exitosamente.');
    }
}
