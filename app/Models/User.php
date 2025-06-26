<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role; // Asegúrate de que esta línea esté presente

class User extends Authenticatable
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
        'role_id', // Deja esto aquí, es correcto
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

    // Relación con el modelo Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // --- AÑADE ESTE MÉTODO BOOT ---
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Asigna un role_id por defecto si no se ha establecido
            // Asegúrate de que 'Cliente' o 'Usuario' exista en tu tabla roles y tenga el ID 2 (o el que corresponda)
            if (is_null($user->role_id)) {
                // Busca el rol 'Cliente' (o el nombre del rol por defecto que quieras)
                $defaultRole = Role::where('nombre', 'cliente')->first(); // <-- ¡CAMBIADO A 'nombre' y 'cliente' en minúsculas!
                if ($defaultRole) {
                    $user->role_id = $defaultRole->id;
                } else {
                    // Fallback: Si no existe 'Cliente', asigna un ID conocido o lanza un error
                    // Considera qué ID quieres para el rol predeterminado (ej: el ID de "Usuario Normal")
                    // Para este ejemplo, asumiremos que el ID 2 existe para el rol por defecto
                    // Puedes ajustar esto según los roles que tengas en tu RoleSeeder
                    $user->role_id = 2; // <<--- ¡CAMBIA ESTE NÚMERO SI TU ID DE ROL POR DEFECTO ES DIFERENTE!
                                        // Por ejemplo, si tu seeder crea 'admin' con ID 1 y 'user' con ID 2,
                                        // y quieres que el por defecto sea 'user', usa 2.
                }
            }
        });
    }
    // --- FIN DEL MÉTODO BOOT ---
}