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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // <-- CAMBIADO de 'name' a 'nombre'
            $table->text('descripcion')->nullable(); // <-- CAMBIADO de 'description' a 'descripcion'
            $table->decimal('precio', 8, 2);
            $table->integer('stock')->default(0); // <-- AÑADIDA esta línea para 'stock'

            // Clave foránea para la categoría
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade'); // <-- CAMBIADO de 'category_id' a 'categoria_id'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};