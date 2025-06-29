<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos'; // Nombre de la tabla
    protected $fillable = [
        'pedido_id',
        'monto',
        'metodo_pago',
        'estado',
        'referencia_transaccion', // Si tienes una referencia externa (ej. de Stripe, PayPal)
    ];

    // Un pago pertenece a un Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
