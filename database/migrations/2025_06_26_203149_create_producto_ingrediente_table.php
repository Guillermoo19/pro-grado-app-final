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
        Schema::create('producto_ingrediente', function (Blueprint $table) {
            $table->id(); // Columna ID para la tabla pivote (opcional pero buena práctica)

            // Claves foráneas a productos y ingredientes
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('ingrediente_id')->constrained('ingredientes')->onDelete('cascade');

            // Columnas adicionales para la relación Many-to-Many
            $table->decimal('cantidad', 8, 2); // Cantidad del ingrediente en el producto (ej. 200.50)
            $table->string('unidad_medida')->default('unidades'); // Unidad de medida (ej. "gramos", "ml", "unidades")

            $table->timestamps();

            // Opcional: Asegurarse de que no haya duplicados de la misma combinación producto-ingrediente
            $table->unique(['producto_id', 'ingrediente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_ingrediente');
    }
};
