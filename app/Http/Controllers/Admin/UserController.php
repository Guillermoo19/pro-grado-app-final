<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios, separada por rol.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $allUsers = User::with('role')->get();

        $admins = collect();
        $clients = collect();
        $otherRoles = collect();
        $noRoleUsers = collect();

        $allUsers->each(function ($user) use (&$admins, &$clients, &$otherRoles, &$noRoleUsers) {
            // Se ha eliminado la l\u00EDnea que ocultaba al usuario autenticado para que puedas verlo en la lista.
            // Si quieres volver a ocultarlo, descomenta esta l\u00EDnea:
            // if ($user->id === Auth::id()) {
            //     return;
            // }

            $roleName = optional($user->role)->nombre;
            
            if ($roleName === 'admin') {
                $admins->push($user);
            } elseif ($roleName === 'cliente') {
                $clients->push($user);
            } elseif (!is_null($roleName)) {
                $otherRoles->push($user);
            } else {
                $noRoleUsers->push($user);
            }
        });

        return view('admin.users.index', compact('admins', 'clients', 'otherRoles', 'noRoleUsers'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     * Ahora ya no carga los roles ya que se asignar\u00E1 un rol por defecto.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        // Ya no es necesario pasar los roles a la vista
        return view('admin.users.create');
    }
    
    /**
     * Almacena un nuevo usuario en la base de datos.
     * Ahora asigna autom\u00E1ticamente el rol 'cliente' por defecto.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $clienteRole = Role::where('nombre', 'cliente')->first();

        if (!$clienteRole) {
            return back()->with('error', 'El rol "cliente" no se ha encontrado en la base de datos.');
        }

        $validated['role_id'] = $clienteRole->id;
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        // Se ha cambiado la redirecci\u00F3n para que actualice la vista
        return $this->index()->with('success', 'User created successfully.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:20',
            'role_id' => [
                'required',
                'integer',
                'exists:roles,id'
            ]
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
    
    /**
     * Actualiza el rol de un usuario.
     */
    public function updateRole(User $user, Request $request)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'role_id' => [
                'required',
                'integer',
                'exists:roles,id'
            ]
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'El rol del usuario ha sido actualizado correctamente.');
    }
    
    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
