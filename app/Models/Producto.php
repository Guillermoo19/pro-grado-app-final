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
        'categoria_id',
        'imagen', // <-- ¡ASEGÚRATE DE QUE ESTA LÍNEA ESTÉ PRESENTE!
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
                    ->withTimestamps();
    }

    // Relación: Un producto puede estar en muchos detalles de pedido (Many-to-Many a través de DetallePedido)
    // No necesitamos una relación directa 'pedidos()' si usamos DetallePedido para los ítems del pedido.
    // DetallePedido ya se encarga de la relación entre Producto y Pedido.
}
