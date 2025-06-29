<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Pedido;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log; // Importar la fachada Log
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
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
        // Define Gates para roles de usuario
        Gate::before(function (User $user, string $ability) {
            Log::info('Gate::before - Usuario: ' . $user->email . ', Habilidad: ' . $ability);

            // Asegura que la relación 'role' del usuario esté cargada.
            if (!$user->relationLoaded('role')) {
                $user->loadMissing('role');
                Log::info('Gate::before - Rol de usuario cargado para: ' . $user->email);
            }

            Log::info('Gate::before - User ID: ' . $user->id . ', Role ID: ' . ($user->role_id ?? 'NULL') . ', Role Name: ' . ($user->role ? $user->role->name : 'N/A') . ', isAdmin(): ' . ($user->isAdmin() ? 'true' : 'false'));

            // Si el usuario es 'admin', permitir todas las habilidades
            if ($user->isAdmin()) {
                Log::info('Gate::before - Usuario ' . $user->email . ' es ADMIN. Permitir acceso.');
                return true;
            }
            Log::info('Gate::before - Usuario ' . $user->email . ' NO es ADMIN o isAdmin() es false.');
        });

        // Define la habilidad 'viewAll' para el modelo Pedido
        Gate::define('viewAll', function (User $user) {
            Log::info('Gate::define(viewAll) - Usuario: ' . $user->email);
            if (!$user->relationLoaded('role')) {
                $user->loadMissing('role');
                Log::info('Gate::define(viewAll) - Rol de usuario cargado (dentro de viewAll): ' . $user->email);
            }
            Log::info('Gate::define(viewAll) - isAdmin() para ' . $user->email . ': ' . ($user->isAdmin() ? 'true' : 'false'));
            return $user->isAdmin();
        });
    }
}
