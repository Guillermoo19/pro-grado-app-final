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
