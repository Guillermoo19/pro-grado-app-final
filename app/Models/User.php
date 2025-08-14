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
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Verifica si el usuario tiene el rol de administrador.
     */
    public function isAdmin()
    {
        // VERIFICACIÓN CORREGIDA POR ÚLTIMA VEZ:
        // Basado en el nombre que se muestra en el menú,
        // el nombre del rol en la base de datos es 'admin' (todo en minúsculas).
        // Se corrige la comparación para que coincida.
        return $this->role && $this->role->nombre === 'admin';
    }

    /**
     * Verifica si el usuario es un SuperAdmin.
     */
    public function isSuperAdmin()
    {
        return $this->role && $this->role->nombre === 'superadmin';
    }

    /**
     * Verifica si el usuario es un cliente.
     */
    public function isCliente()
    {
        return $this->role && $this->role->nombre === 'cliente';
    }
}
