<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Estas columnas ya se crean en la migración principal de la tabla 'pedidos',
            // por lo que no es necesario volver a crearlas aquí.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar las columnas si se revierte la migración
            $table->dropColumn('telefono_contacto');
            $table->dropColumn('direccion_entrega');
            $table->dropColumn('tipo_entrega');
        });
    }
};
