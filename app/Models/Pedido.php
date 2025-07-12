<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total',
        'estado_pedido',
        'estado_pago',
        'comprobante_url',
        'tipo_entrega',
        'direccion_entrega',
        'telefono_contacto',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The products that belong to the order.
     *
     * CAMBIO AQUÍ: Especificamos el nombre de la tabla pivote 'detalle_pedidos'
     * para que coincida con la migración.
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_pedidos') // <-- CAMBIO AQUÍ
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                    ->withTimestamps();
    }
}
