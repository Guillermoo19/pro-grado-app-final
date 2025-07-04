<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Clave foránea a 'users'

            // ELIMINAMOS 'order_date' porque 'created_at' de timestamps() hará esta función.
            // $table->dateTime('order_date'); // <-- ¡ELIMINAR ESTA LÍNEA!

            // Renombramos 'total_amount' a 'total'
            $table->decimal('total', 10, 2); // Renombrado a 'total'

            // Renombramos 'status' a 'estado'
            $table->string('estado')->default('pendiente'); // Renombrado a 'estado'

            $table->timestamps(); // Esto añade 'created_at' y 'updated_at' automáticamente
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
