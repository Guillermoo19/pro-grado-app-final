<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Define los campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre', // <-- Asegúrate de que 'nombre' esté aquí
    ];

    // Si tu tabla de roles no se llama 'roles', deberías especificarlo:
    // protected $table = 'nombre_de_tu_tabla_de_roles';
}