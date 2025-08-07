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
            // Columna para la URL del comprobante de pago
            // La agregamos después de 'estado_pedido'
            $table->string('comprobante_imagen_url')->nullable()->after('estado_pedido');
            
            // La columna 'estado_pago' ya se crea en la migración de la tabla 'pedidos', así que la eliminamos de aquí
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Para revertir la migración, eliminamos la columna que agregamos
            $table->dropColumn('comprobante_imagen_url');
        });
    }
};
