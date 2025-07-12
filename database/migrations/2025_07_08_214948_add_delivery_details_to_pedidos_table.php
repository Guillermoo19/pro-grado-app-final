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
            // Añadir la columna 'tipo_entrega' (ej. 'local', 'domicilio')
            // Se coloca después de 'estado_pago' para mantener un orden lógico
            $table->string('tipo_entrega')->default('local')->after('estado_pago');
            
            // Añadir la columna 'direccion_entrega' (nullable porque no aplica para 'local')
            $table->string('direccion_entrega')->nullable()->after('tipo_entrega');
            
            // Añadir la columna 'telefono_contacto' (nullable porque puede venir del perfil del usuario o ser opcional)
            $table->string('telefono_contacto')->nullable()->after('direccion_entrega');
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
