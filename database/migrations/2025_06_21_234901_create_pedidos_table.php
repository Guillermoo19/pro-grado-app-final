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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Clave foránea a 'users'
            $table->dateTime('order_date'); // Tu campo para la fecha/hora del pedido
            $table->decimal('total_amount', 10, 2); // Tu campo para el monto total
            $table->string('status')->default('pendiente'); // Tu campo para el estado
            $table->timestamps(); // Esto añadirá 'created_at' y 'updated_at' automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
