<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios, separada por rol.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        // Obtenemos todos los usuarios y sus roles.
        $allUsers = User::with('role')->get();

        // Si el usuario autenticado es el super admin, muestra todos los usuarios.
        if (Auth::user()->isSuperAdmin()) {
            $admins = $allUsers->filter(fn($user) => optional($user->role)->nombre === 'admin');
            $clients = $allUsers->filter(fn($user) => optional($user->role)->nombre === 'cliente');
            $otherRoles = $allUsers->filter(fn($user) => optional($user->role)->nombre !== 'admin' && optional($user->role)->nombre !== 'cliente' && !is_null($user->role));
            $noRoleUsers = $allUsers->filter(fn($user) => is_null($user->role));
            
            return view('admin.users.index', compact('admins', 'clients', 'otherRoles', 'noRoleUsers'));
        } 
        
        // Si el usuario autenticado es un admin regular.
        else {
            // Filtramos para no mostrarse a sí mismo ni al super admin.
            $admins = $allUsers->filter(fn($user) => optional($user->role)->nombre === 'admin' && $user->id !== Auth::id() && $user->id !== 1);
            $clients = $allUsers->filter(fn($user) => optional($user->role)->nombre === 'cliente' && $user->id !== Auth::id());
            $otherRoles = $allUsers->filter(fn($user) => optional($user->role)->nombre !== 'admin' && optional($user->role)->nombre !== 'cliente' && !is_null($user->role) && $user->id !== Auth::id());
            $noRoleUsers = $allUsers->filter(fn($user) => is_null($user->role) && $user->id !== Auth::id());
            
            return view('admin.users.index', compact('admins', 'clients', 'otherRoles', 'noRoleUsers'));
        }
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        // Se obtienen todos los roles disponibles para el select.
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza la información de un usuario en la base de datos.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validatedData = $request->validated();

        // Preparamos un array con los datos que se actualizarán.
        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number']
        ];

        // CORRECCIÓN: Si el usuario autenticado es un SuperAdmin y se envió un role_id,
        // lo incluimos en los datos para la actualización.
        if (Auth::user()->isSuperAdmin() && isset($validatedData['role_id'])) {
            $updateData['role_id'] = $validatedData['role_id'];
        }

        // Realizamos la actualización de una sola vez.
        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }
    
    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }
    
    /**
     * Asigna el rol de administrador a un usuario.
     */
    public function makeAdmin(User $user)
    {
        $this->authorize('update', $user);

        // Obtener el rol de administrador por nombre.
        $adminRole = Role::where('nombre', 'admin')->first();

        // Asignar el rol si existe.
        if ($adminRole) {
            $user->role_id = $adminRole->id;
            $user->save();
            return redirect()->back()->with('success', 'El usuario ha sido asignado como administrador.');
        }

        return redirect()->back()->with('error', 'No se encontró el rol de administrador.');
    }
}
