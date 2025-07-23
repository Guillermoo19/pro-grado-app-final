<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Pedido;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Log; // Elimina esta línea si ya no la necesitas
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\Categoria::class => \App\Policies\CategoriaPolicy::class,
        \App\Models\Producto::class => \App\Policies\ProductoPolicy::class,
        \App\Models\Ingrediente::class => \App\Policies\IngredientePolicy::class,
        \App\Models\Pedido::class => \App\Policies\PedidoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user, string $ability) {
            // Elimina las líneas de depuración
            // Log::info('AuthServiceProvider - Gate::before - Usuario: ' . $user->email . ', Habilidad: ' . $ability);

            if (! $user->relationLoaded('role')) {
                $user->loadMissing('role');
                // Log::info('AuthServiceProvider - Gate::before - Rol de usuario cargado para: ' . $user->email); // Elimina esta línea
            }

            // Elimina las líneas de depuración
            // Log::info('AuthServiceProvider - Gate::before - User ID: ' . $user->id . ', Role ID: ' . ($user->role_id ?? 'NULL') . ', Role Name: ' . ($user->role ? $user->role->nombre : 'N/A') . ', isAdmin(): ' . ($user->isAdmin() ? 'true' : 'false'));

            if ($user->isAdmin()) {
                // Log::info('AuthServiceProvider - Gate::before - Usuario ' . $user->email . ' es ADMIN. Permitir acceso.'); // Elimina esta línea
                return true;
            }

            // Log::info('AuthServiceProvider - Gate::before - Usuario ' . $user->email . ' NO es ADMIN o isAdmin() es false. Continuando con otros Gates/Policies.'); // Elimina esta línea
            return null;
        });
    }
}
