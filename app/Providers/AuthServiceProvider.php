<?php

namespace App\Providers;

// Importa los modelos y las políticas
use App\Models\Role;
use App\Policies\RolePolicy;
use App\Models\Categoria;
use App\Policies\CategoriaPolicy;
use App\Models\Producto;
use App\Policies\ProductoPolicy;
use App\Models\Ingrediente; // <-- ¡AÑADE ESTA LÍNEA!
use App\Policies\IngredientePolicy; // <-- ¡AÑADE ESTA LÍNEA!

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        Categoria::class => CategoriaPolicy::class,
        Producto::class => ProductoPolicy::class,
        Ingrediente::class => IngredientePolicy::class, // <-- ¡AÑADE ESTA LÍNEA!
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
