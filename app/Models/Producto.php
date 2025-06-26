<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id', // Asegúrate de que esta línea esté presente
        'imagen', // Asegúrate de que esta línea esté presente
    ];

    // Relación: Un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación: Un producto puede tener muchos ingredientes (Many-to-Many)
    // Usamos withPivot para incluir las columnas 'cantidad' y 'unidad_medida' de la tabla pivote
    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'producto_ingrediente')
                    ->withPivot('cantidad', 'unidad_medida')
                    ->withTimestamps(); // Para que Laravel maneje created_at y updated_at en la tabla pivote
    }
}
