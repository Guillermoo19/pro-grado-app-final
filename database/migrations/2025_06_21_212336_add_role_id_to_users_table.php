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
        Schema::table('users', function (Blueprint $table) {
            // Permitir que role_id sea nulo. Esto soluciona el error 1364 al registrar nuevos usuarios
            // si no se les asigna un rol de inmediato.
            // La foreign key constrainst se asegura de que si el rol padre se borra,
            // el role_id en users se ponga a null.
            $table->foreignId('role_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
