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
        Schema::table('productos', function (Blueprint $table) {
            // Añade la columna 'imagen' después de 'categoria_id'
            $table->string('imagen')->nullable()->after('categoria_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Elimina la columna 'imagen' si se revierte la migración
            $table->dropColumn('imagen');
        });
    }
};
