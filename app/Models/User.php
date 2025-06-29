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
        'role_id', // Asegúrate de que 'role_id' esté aquí
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime', 
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the orders for the user.
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has the 'admin' role.
     * ¡CORRECCIÓN AQUÍ! Cargando la relación 'role' si no está ya cargada
     */
    public function isAdmin(): bool
    {
        // Asegúrate de que la relación 'role' esté cargada.
        // Si no está cargada, la carga de la base de datos para evitar errores.
        // Esto es útil en contextos donde el usuario no se carga con 'with('role')'.
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }
        
        // Verifica si el rol existe y si su nombre es 'admin'.
        return $this->role !== null && $this->role->name === 'admin';
    }
}
