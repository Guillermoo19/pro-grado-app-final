<?php

// AHORA el namespace debe ser el de la carpeta 'Auth'
namespace App\Http\Controllers\Auth;

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
        $this->authorize('viewAny', User::class); // Autoriza la visualización

        // Obtenemos todos los usuarios y sus roles en una sola consulta para evitar N+1
        $allUsers = User::with('role')->get();

        // Si el usuario autenticado es el super admin (ID 1), muestra todos los usuarios.
        if (Auth::user()->isSuperAdmin()) {
            $admins = $allUsers->filter(fn($user) => optional($user->role)->nombre === 'admin');
            $clients = $allUsers->filter(fn($user) => optional($user->role)->nombre === 'cliente');
            $otherRoles = $allUsers->filter(fn($user) => optional($user->role)->nombre !== 'admin' && optional($user->role)->nombre !== 'cliente' && !is_null($user->role));
            $noRoleUsers = $allUsers->filter(fn($user) => is_null($user->role));
            
            return view('admin.users.index', compact('admins', 'clients', 'otherRoles', 'noRoleUsers'));
        } 
        
        // Si el usuario autenticado es un admin regular, filtra para no mostrarse a sí mismo
        // ni al super admin.
        else {
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

        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza la información de un usuario en la base de datos.
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
     * Elimina un usuario de la base de datos.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
