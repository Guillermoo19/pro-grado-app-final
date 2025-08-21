<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usa firstOrCreate para crear el rol si no existe
        Role::firstOrCreate(['nombre' => 'admin']);
        Role::firstOrCreate(['nombre' => 'cliente']); // Añadimos esta línea de forma temporal

        $this->command->info('Roles creados correctamente!');
    }
}
