<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $fillable = [
        'user_id',
        'order_date',
        'total_amount',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}