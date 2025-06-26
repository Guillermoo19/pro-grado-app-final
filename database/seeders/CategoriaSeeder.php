<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB; // Añade esta línea para usar la fachada DB

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Deshabilitar la comprobación de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Categoria::truncate(); 

        // Habilitar la comprobación de claves foráneas de nuevo
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        // Crear algunas categorías de ejemplo
        Categoria::create([
            'nombre' => 'Electrónica',
            'descripcion' => 'Dispositivos electrónicos y gadgets.',
        ]);

        Categoria::create([
            'nombre' => 'Ropa y Accesorios',
            'descripcion' => 'Prendas de vestir y complementos.',
        ]);

        Categoria::create([
            'nombre' => 'Alimentos y Bebidas',
            'descripcion' => 'Productos comestibles y bebidas.',
        ]);

        Categoria::create([
            'nombre' => 'Hogar y Decoración',
            'descripcion' => 'Artículos para el hogar y adornos.',
        ]);

        echo "Categorías creadas correctamente.\n";
    }
}