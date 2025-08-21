<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Se agrega la importación del modelo Role
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validamos la solicitud, incluyendo la unicidad del email
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Se busca el rol de 'cliente' para asignarlo al nuevo usuario
        // Si no se encuentra, el rol se dejará como `null`.
        $clienteRole = Role::where('nombre', 'cliente')->first();

        // Se crea el usuario con todos los datos, incluyendo el 'role_id'.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number ?? null, // Asume que `phone_number` puede venir en el request
            'role_id' => $clienteRole ? $clienteRole->id : null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Se corrige la redirección a la ruta de productos.
        return redirect()->route('productos.index'); 
    }
}
