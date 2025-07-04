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
            // Columna para la URL del comprobante de pago (puede ser nula al principio)
            $table->string('comprobante_imagen_url')->nullable()->after('estado');

            // Columna para el estado del pago (ej. 'pendiente', 'verificado', 'rechazado')
            // Por defecto será 'pendiente'
            $table->string('estado_pago')->default('pendiente')->after('comprobante_imagen_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Para revertir la migración, eliminamos las columnas
            $table->dropColumn('comprobante_imagen_url');
            $table->dropColumn('estado_pago');
        });
    }
};
