<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'estado',
        'comprobante_imagen_url', // NUEVA COLUMNA
        'estado_pago',            // NUEVA COLUMNA
    ];

    /**
     * Los atributos que deberían ser casteados.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    /**
     * Relación con el usuario que hizo el pedido.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * La relación con los productos del pedido (a través de la tabla pivote detalle_pedidos).
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'detalle_pedidos')
                     ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                     ->withTimestamps();
    }

    // Puedes añadir otros métodos o relaciones aquí si es necesario
}
