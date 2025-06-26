<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['nombre' => 'admin']); // <-- DEBE SER 'nombre'
        Role::firstOrCreate(['nombre' => 'cliente']); // <-- DEBE SER 'nombre'
        $this->command->info('Roles creados correctamente!');
    }
}