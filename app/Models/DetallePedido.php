<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'detalle_pedidos'; // Nombre de la tabla
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario', // Precio del producto en el momento de la compra
    ];

    // Un detalle de pedido pertenece a un Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Un detalle de pedido pertenece a un Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
