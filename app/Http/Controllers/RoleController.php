<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de que esta línea esté presente

class RoleController extends Controller
{
    // Constructor para aplicar políticas si es necesario a todo el controlador
    public function __construct()
    {
        // Se aplicará la autorización en cada método para mayor claridad.
    }

    /**
     * Display a listing of the resource.
     * Muestra la lista de roles para el panel de administración.
     */
    public function index()
    {
        // Autoriza que el usuario puede ver cualquier rol
        $this->authorize('viewAny', Role::class);

        $roles = Role::all();
        // CAMBIO CLAVE: Cargar la vista desde la carpeta admin
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear un nuevo rol.
     */
    public function create()
    {
        // Autoriza que el usuario puede crear roles
        $this->authorize('create', Role::class);

        // CAMBIO CLAVE: Cargar la vista desde la carpeta admin
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * Almacena un nuevo rol en la base de datos.
     */
    public function store(Request $request)
    {
        // Autoriza que el usuario puede crear roles (la misma que 'create')
        $this->authorize('create', Role::class);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre',
        ],
        [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Este nombre de rol ya existe.',
            'nombre.max' => 'El nombre del rol no debe exceder los 255 caracteres.',
        ]);

        Role::create([
            'nombre' => $request->nombre,
        ]);

        // Redirige a la ruta de administración
        return redirect()->route('admin.roles.index')->with('success', 'Rol creado exitosamente.');
    }

    /**
     * Display the specified resource.
     * Muestra los detalles de un rol específico (si se implementa).
     */
    public function show(Role $role)
    {
        // Autoriza que el usuario puede ver este rol específico
        $this->authorize('view', $role);

        // Si no tienes una vista específica para 'show', puedes mantener abort(404)
        // o redirigir a la lista de roles.
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar un rol existente.
     */
    public function edit(Role $role)
    {
        // Autoriza que el usuario puede actualizar este rol específico
        $this->authorize('update', $role);

        // CAMBIO CLAVE: Cargar la vista desde la carpeta admin
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza un rol existente en la base de datos.
     */
    public function update(Request $request, Role $role)
    {
        // Autoriza que el usuario puede actualizar este rol específico
        $this->authorize('update', $role);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $role->id,
        ],
        [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Este nombre de rol ya existe.',
            'nombre.max' => 'El nombre del rol no debe exceder los 255 caracteres.',
        ]);

        $role->update(['nombre' => $request->nombre]);

        // Redirige a la ruta de administración
        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Elimina un rol de la base de datos.
     */
    public function destroy(Role $role)
    {
        // Autoriza que el usuario puede eliminar este rol específico
        $this->authorize('delete', $role);

        $role->delete();

        // Redirige a la ruta de administración
        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
