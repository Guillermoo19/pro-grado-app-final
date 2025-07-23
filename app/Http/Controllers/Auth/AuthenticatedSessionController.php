<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
// use Illuminate\Support\Facades\Log; // Elimina esta línea si ya no la necesitas

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

        // Elimina las líneas de depuración
        // Log::info('AuthenticatedSessionController - store: User ID: ' . Auth::id());
        // Log::info('AuthenticatedSessionController - store: isAdmin(): ' . (Auth::user()->isAdmin() ? 'true' : 'false'));
        // Log::info('AuthenticatedSessionController - store: User Role Name: ' . (Auth::user()->role ? Auth::user()->role->nombre : 'No Role'));

        // Lógica de redirección basada en el rol del usuario
        if (Auth::user()->isAdmin()) {
            // Log::info('AuthenticatedSessionController - store: User is admin, redirecting to admin dashboard.'); // Elimina esta línea
            return redirect()->route('admin.dashboard');
        }

        // Log::info('AuthenticatedSessionController - store: User is NOT admin, redirecting to normal dashboard.'); // Elimina esta línea
        return redirect()->route('dashboard');
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
