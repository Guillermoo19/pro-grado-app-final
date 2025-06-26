<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategoriaSeeder::class, // ¡Añade esta línea!
            ProductoSeeder::class,  // ¡Añade esta línea!
        ]);

        // Opcional: Puedes descomentar estas líneas para crear un usuario admin de prueba
        // \App\Models\User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('password'),
        //     'role_id' => \App\Models\Role::where('name', 'admin')->first()->id,
        // ]);
        // \App\Models\User::factory(10)->create(); // Esto crearía 10 usuarios de prueba aleatorios
    }
}