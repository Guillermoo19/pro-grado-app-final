<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación: Un ingrediente puede estar en muchos productos (Many-to-Many)
    // Usamos withPivot para incluir las columnas 'cantidad' y 'unidad_medida' de la tabla pivote
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_ingrediente')
                    ->withPivot('cantidad', 'unidad_medida')
                    ->withTimestamps(); // Para que Laravel maneje created_at y updated_at en la tabla pivote
    }
}
