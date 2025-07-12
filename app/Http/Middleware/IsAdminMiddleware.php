<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y si es administrador
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Redirige si no tiene permisos
        return redirect()->route('dashboard')->with('error', 'Acceso denegado. No tienes permisos de administrador.');
    }
}