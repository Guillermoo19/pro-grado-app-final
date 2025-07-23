<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios.
     */
    public function index()
    {
        // Carga la relación 'role' para poder acceder a $user->role->name
        $users = User::with('role')->where('id', '!=', Auth::id())
                     ->where('id', '!=', 1) // Asume que el super admin tiene ID 1
                     ->orderBy('name')
                     ->get();

        // Si el usuario autenticado es el super admin, puede verse a sí mismo en la lista
        // y también puede ver al usuario con ID 1 (el super admin)
        if (Auth::user()->isSuperAdmin()) {
            $users = User::with('role')->orderBy('name')->get();
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra los detalles de un usuario específico.
     */
    public function show(User $user)
    {
        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(User $user)
    {
        // Restricción: Un admin normal no puede editar al super admin (ID 1)
        if ($user->isSuperAdmin() && !Auth::user()->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permiso para editar al administrador general.');
        }

        // Carga la relación 'role' para la vista
        $user->load('role');

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualiza la información de un usuario en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        // Restricción: Un admin normal no puede editar al super admin (ID 1)
        if ($user->isSuperAdmin() && !Auth::user()->isSuperAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permiso para editar al administrador general.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number' => 'nullable|string|max:20',
        ];

        // Solo el super admin puede cambiar el rol
        if (Auth::user()->isSuperAdmin()) {
            $rules['role_id'] = ['required', 'integer', Rule::in([1, 2, 5])]; // Ajusta los IDs de rol si tienes más
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        // Solo el super admin puede cambiar el rol
        if (Auth::user()->isSuperAdmin()) {
            $user->role_id = $request->role_id; // <-- ¡IMPORTANTE! Cambiado a role_id
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado con éxito.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(User $user)
    {
        // Restricción: No permitir que un admin se elimine a sí mismo
        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta de usuario.');
        }

        // Restricción: No permitir que un admin normal elimine al super admin (ID 1)
        if ($user->isSuperAdmin() && !Auth::user()->isSuperAdmin()) {
            return back()->with('error', 'No tienes permiso para eliminar al administrador general.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado con éxito.');
    }
}
