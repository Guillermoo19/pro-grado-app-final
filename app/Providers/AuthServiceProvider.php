<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Pedido;
use Illuminate\Support\Facades\Gate;
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
        // Se define la Gate 'access-admin' que se usa en las rutas.
        Gate::define('access-admin', function (User $user) {
            // Se usa la función isAdmin() del modelo User para verificar el rol.
            return $user->isAdmin();
        });

        // La Gate::before es una buena práctica, pero no estaba resolviendo el
        // problema de la Gate 'access-admin'. Para que funcione, la Gate
        // debe estar explícitamente definida.
        Gate::before(function (User $user, string $ability) {
            if (! $user->relationLoaded('role')) {
                $user->loadMissing('role');
            }

            if ($user->isAdmin()) {
                return true;
            }

            return null;
        });
    }
}
