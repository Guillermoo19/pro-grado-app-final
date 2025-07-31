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
        // Se aplicará la autorización en cada método para mayor claridad.
    }

    /**
     * Display a listing of the resource.
     * Muestra la lista de ingredientes para el panel de administración.
     */
    public function index()
    {
        $this->authorize('viewAny', Ingrediente::class); // Autoriza ver la lista de ingredientes

        $ingredientes = Ingrediente::all();
        // CAMBIO CLAVE: Cargar la vista desde la carpeta admin
        return view('admin.ingredientes.index', compact('ingredientes'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear un nuevo ingrediente.
     */
    public function create()
    {
        $this->authorize('create', Ingrediente::class); // Autoriza crear un ingrediente

        // CAMBIO CLAVE: Cargar la vista desde la carpeta admin
        return view('admin.ingredientes.create');
    }

    /**
     * Store a newly created resource in storage.
     * Almacena un nuevo ingrediente en la base de datos.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Ingrediente::class); // Autoriza crear un ingrediente

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

        // Redirige a la ruta de administración
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     * Muestra los detalles de un ingrediente específico (si se implementa).
     */
    public function show(Ingrediente $ingrediente)
    {
        $this->authorize('view', $ingrediente); // Autoriza ver este ingrediente específico

        // Si no tienes una vista específica para 'show', puedes mantener abort(404)
        // o redirigir a la lista de ingredientes.
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar un ingrediente existente.
     */
    public function edit(Ingrediente $ingrediente)
    {
        $this->authorize('update', $ingrediente); // Autoriza actualizar este ingrediente específico

        // CAMBIO CLAVE: Cargar la vista desde la carpeta admin
        return view('admin.ingredientes.edit', compact('ingrediente'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza un ingrediente existente en la base de datos.
     */
    public function update(Request $request, Ingrediente $ingrediente)
    {
        $this->authorize('update', $ingrediente); // Autoriza actualizar este ingrediente específico

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

        // Redirige a la ruta de administración
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Elimina un ingrediente de la base de datos.
     */
    public function destroy(Ingrediente $ingrediente)
    {
        $this->authorize('delete', $ingrediente); // Autoriza eliminar este ingrediente específico

        $ingrediente->delete();

        // Redirige a la ruta de administración
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente eliminado exitosamente.');
    }
}
