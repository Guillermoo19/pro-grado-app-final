<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Recargar el usuario autenticado para asegurar que el rol esté actualizado
        Auth::setUser(Auth::user()->fresh()); 

        // Lógica de redirección basada en el rol del usuario
        // Nota: La función isAdmin() debe estar definida en tu modelo User
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Si no es admin, lo redirige a la página principal de productos
        return redirect()->route('productos.index'); 
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
