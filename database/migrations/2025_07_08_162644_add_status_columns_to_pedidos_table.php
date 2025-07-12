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
            // Añadir la columna 'estado_pedido' después de 'total'
            $table->string('estado_pedido')->default('pendiente')->after('total');
            // Añadir la columna 'estado_pago' después de 'estado_pedido'
            $table->string('estado_pago')->default('pendiente')->after('estado_pedido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar las columnas si se revierte la migración
            $table->dropColumn('estado_pedido');
            $table->dropColumn('estado_pago');
        });
    }
};