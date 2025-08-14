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
        'imagen',
    ];

    // Relación: Un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * CORRECCIÓN: Se cambia el nombre de la relación a 'ingredientes'
     * para que coincida con la llamada del controlador.
     */
    public function ingredientes() // Cambiado de 'ingredientesAdicionales' a 'ingredientes'
    {
        return $this->belongsToMany(Ingrediente::class, 'producto_ingrediente')
                     ->withPivot('cantidad', 'unidad_medida')
                     ->withTimestamps();
    }
    
    // Nueva relación para el pedido, usando la tabla 'pedido_producto'
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_producto')
                     ->withPivot(['cantidad', 'ingredientes_adicionales'])
                     ->withTimestamps();
    }
}
