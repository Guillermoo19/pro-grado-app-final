<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Log; // Ya no es necesario importar Log si no se usa

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        $adminRole = Role::where('nombre', 'admin')->first();
        $clientRole = Role::where('nombre', 'cliente')->first();

        if (!$adminRole || !$clientRole) {
            echo "ERROR: No se encontraron los roles 'admin' o 'cliente'. Asegúrate de que RoleSeeder los cree.\n";
            return;
        }

        // Contraseña hasheada fija para 'password' (generada previamente con Hash::make('password'))
        $fixedHashedPassword = '$2y$12$.5aRmya0fQXXjZ956OTYqOeKX.o57.jF7Ev5JWWbyx8YCsYyGZ5P.'; 

        User::create([
            'name' => 'Susi Admin',
            'email' => 'susi@gmail.com',
            'password' => $fixedHashedPassword, // Usamos el hash fijo
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Guillermo Cliente',
            'email' => 'guillermo@gmail.com',
            'password' => $fixedHashedPassword, // Usamos el mismo hash fijo
            'role_id' => $clientRole->id,
        ]);

        $this->call([
            CategoriaSeeder::class,
            ProductoSeeder::class,
        ]);

        echo "Roles, Usuarios (Susi, Guillermo) y Productos sembrados correctamente.\n";
    }
}
