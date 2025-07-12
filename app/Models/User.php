<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // ¡IMPORTANTE! Asegúrate de que 'role_id' sea fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // Si role_id es un entero, no necesita ser casteado a un tipo específico aquí a menos que quieras
    ];

    /**
     * Define the relationship with Pedido (one-to-many).
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Check if the user has the 'admin' role.
     *
     * @return bool
     */
    public function isAdmin()
    {
        // Basado en tu base de datos, el role_id para 'admin' es 1.
        // Asegúrate de que este ID (1) corresponda al ID del rol de administrador en tu tabla 'roles'.
        return $this->role_id === 1;
    }

    /**
     * Define the relationship with Role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
