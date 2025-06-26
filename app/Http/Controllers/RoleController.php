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
        // Opcional: Si quieres aplicar la política a todos los métodos del controlador,
        // excepto los especificados, puedes usar el middleware 'can'.
        // Sin embargo, para mayor claridad, lo aplicaremos en cada método.
        // $this->middleware('can:viewAny,App\Models\Role')->only('index');
        // $this->middleware('can:create,App\Models\Role')->only('create', 'store');
        // $this->middleware('can:update,role')->only('edit', 'update'); // 'role' es el nombre del parámetro de ruta
        // $this->middleware('can:delete,role')->only('destroy');
    }

    public function index()
    {
        // Autoriza que el usuario puede ver cualquier rol
        $this->authorize('viewAny', Role::class); // <-- ¡AÑADE ESTA LÍNEA!

        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        // Autoriza que el usuario puede crear roles
        $this->authorize('create', Role::class); // <-- ¡AÑADE ESTA LÍNEA!

        return view('roles.create');
    }

    public function store(Request $request)
    {
        // Autoriza que el usuario puede crear roles (la misma que 'create')
        $this->authorize('create', Role::class); // <-- ¡AÑADE ESTA LÍNEA!

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

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function show(Role $role)
    {
        // Autoriza que el usuario puede ver este rol específico
        $this->authorize('view', $role); // <-- ¡AÑADE ESTA LÍNEA!

        abort(404); // O la vista de show si la implementas
    }

    public function edit(Role $role)
    {
        // Autoriza que el usuario puede actualizar este rol específico
        $this->authorize('update', $role); // <-- ¡AÑADE ESTA LÍNEA!

        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        // Autoriza que el usuario puede actualizar este rol específico
        $this->authorize('update', $role); // <-- ¡AÑADE ESTA LÍNEA!

        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $role->id,
        ],
        [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Este nombre de rol ya existe.',
            'nombre.max' => 'El nombre del rol no debe exceder los 255 caracteres.',
        ]);

        $role->update(['nombre' => $request->nombre]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        // Autoriza que el usuario puede eliminar este rol específico
        $this->authorize('delete', $role); // <-- ¡AÑADE ESTA LÍNEA!

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}