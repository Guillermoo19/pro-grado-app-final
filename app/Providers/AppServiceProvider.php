<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // Asegúrate de que esta línea esté presente si no lo está

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Añade esta línea para establecer las rondas de bcrypt
        \Hash::setRounds(12);

        // Si ya tienes Schema::defaultStringLength(191); déjalo.
        // Si no, no es estrictamente necesario para este problema, pero es una buena práctica.
        // Schema::defaultStringLength(191);
    }
}
