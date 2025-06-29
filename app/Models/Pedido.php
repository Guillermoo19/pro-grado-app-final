<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos'; // Es buena práctica especificarlo si no es la convención plural perfecta
    protected $fillable = [
        'user_id',
        'order_date',
        'total_amount',
        'status',
    ];

    // ************************************************
    // NUEVA LÍNEA: Casts para convertir order_date a un objeto Carbon
    // ************************************************
    protected $casts = [
        'order_date' => 'datetime',
    ];

    // Un pedido pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un pedido tiene muchos detalles de pedido (los ítems/productos del pedido)
    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }

    // Un pedido puede tener muchos pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
