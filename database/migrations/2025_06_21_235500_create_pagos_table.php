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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago'); // Ej: "tarjeta", "efectivo", "transferencia"
            $table->string('estado')->default('pendiente'); // Ej: "pendiente", "completado", "fallido"
            $table->string('referencia_transaccion')->nullable(); // Para ID de transacción externa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
