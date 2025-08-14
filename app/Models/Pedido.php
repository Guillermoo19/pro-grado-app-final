<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use HasFactory;

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
     * Relación con el usuario que hizo el pedido.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación uno a muchos con los detalles del pedido.
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePedido::class);
    }

    /**
     * Relación de muchos a muchos con productos a través de la tabla pivote.
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_pedidos')
            ->withPivot('cantidad', 'precio_unitario', 'subtotal', 'ingredientes_adicionales')
            ->withTimestamps();
    }
}
