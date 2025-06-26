<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Añade esta línea
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory; // <-- Añade esta línea

    protected $table = 'categorias'; // Esto es opcional si tu tabla ya se llama 'categorias'
                                    // Laravel lo infiere por defecto si el modelo es 'Categoria'

    protected $fillable = ['nombre', 'descripcion']; // <-- ¡CAMBIA ESTA LÍNEA!

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id'); // Asegúrate de especificar la clave foránea si no sigue la convención por defecto
    }
}