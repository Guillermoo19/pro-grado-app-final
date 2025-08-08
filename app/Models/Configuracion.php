<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuracion extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'configuracion';
    
    // Los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'banco', 
        'numero_cuenta', 
        'nombre_titular', 
        'tipo_cuenta', 
        'numero_contacto'
    ];
}
