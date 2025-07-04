<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Asegúrate de que esta línea esté presente

class DetallePedido extends Model
{
    use HasFactory;

    // Si tu tabla de ítems de pedido se llama 'detalle_pedidos', esto no es necesario.
    // Si tu tabla se llama de otra forma, por ejemplo, 'order_items', descomenta y ajusta:
    // protected $table = 'nombre_de_tu_tabla_de_items_de_pedido';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario', // Precio del producto en el momento de la compra
        'subtotal', // <--- ¡DESCOMENTADO Y AÑADIDO A $fillable!
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
