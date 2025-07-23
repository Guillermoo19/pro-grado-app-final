<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Facades\Log; // Elimina esta línea si ya no la necesitas

class LoadUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Carga la relación 'role' si el usuario está autenticado
            Auth::user()->loadMissing('role');

            // Elimina las líneas de depuración
            // Log::info('LoadUserRole Middleware: User ID: ' . Auth::id());
            // Log::info('LoadUserRole Middleware: User Role Name: ' . (Auth::user()->role ? Auth::user()->role->nombre : 'No Role'));
            // Log::info('LoadUserRole Middleware: isAdmin(): ' . (Auth::user()->isAdmin() ? 'true' : 'false'));
        }
        return $next($request);
    }
}
