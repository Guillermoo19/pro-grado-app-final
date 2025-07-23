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
        'phone_number',
        'role_id',
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
    ];

    /**
     * Define la relación con el modelo Role.
     * Un usuario pertenece a un rol.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Define la relación con los pedidos del usuario.
     * Un usuario puede tener muchos pedidos.
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Verifica si el usuario tiene el rol de administrador.
     * Utiliza la relación 'role' y el campo 'nombre' del rol.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role && $this->role->nombre === 'admin';
    }

    /**
     * Verifica si el usuario es el administrador general (super admin).
     * Asumimos que el administrador general tiene el ID 1.
     */
    public function isSuperAdmin()
    {
        return $this->id === 1;
    }
}
