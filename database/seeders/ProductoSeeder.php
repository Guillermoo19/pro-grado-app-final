<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB; // Añade esta línea para usar la fachada DB

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Deshabilitar la comprobación de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Producto::truncate();

        // Habilitar la comprobación de claves foráneas de nuevo
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        // Obtener algunas IDs de categorías existentes (asumiendo que CategoriaSeeder ya se ejecutó)
        $electronicaId = Categoria::where('nombre', 'Electrónica')->first()->id ?? 1;
        $ropaId = Categoria::where('nombre', 'Ropa y Accesorios')->first()->id ?? 2;
        $alimentosId = Categoria::where('nombre', 'Alimentos y Bebidas')->first()->id ?? 3;

        // Crear productos de ejemplo
        Producto::create([
            'nombre' => 'Smartphone X',
            'descripcion' => 'Último modelo de smartphone con cámara de alta resolución.',
            'precio' => 799.99,
            'stock' => 50,
            'categoria_id' => $electronicaId,
        ]);

        Producto::create([
            'nombre' => 'Camiseta de Algodón',
            'descripcion' => 'Camiseta básica de algodón 100%, varios colores.',
            'precio' => 19.95,
            'stock' => 200,
            'categoria_id' => $ropaId,
        ]);

        Producto::create([
            'nombre' => 'Café Gourmet 250g',
            'descripcion' => 'Granos de café arábica, tostado medio.',
            'precio' => 12.50,
            'stock' => 150,
            'categoria_id' => $alimentosId,
        ]);

        Producto::create([
            'nombre' => 'Smartwatch Pro',
            'descripcion' => 'Reloj inteligente con monitor de ritmo cardíaco.',
            'precio' => 199.00,
            'stock' => 30,
            'categoria_id' => $electronicaId,
        ]);

        echo "Productos creados correctamente.\n";
    }
}