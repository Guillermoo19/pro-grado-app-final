<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePedido extends Model
{
    use HasFactory;

    // La tabla de la base de datos a la que corresponde el modelo.
    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario', // Precio del producto base al momento de la compra
        'subtotal', // Precio total del ítem (producto + ingredientes)
        'ingredientes_adicionales', // Lista de ingredientes adicionales en formato JSON
    ];

    /**
     * Define los atributos que deben ser convertidos a tipos de datos nativos.
     */
    protected $casts = [
        'ingredientes_adicionales' => 'array', // Esta línea es fundamental
    ];

    /**
     * Relación con el pedido al que pertenece este detalle.
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    /**
     * Relación con el producto específico de este detalle.
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
