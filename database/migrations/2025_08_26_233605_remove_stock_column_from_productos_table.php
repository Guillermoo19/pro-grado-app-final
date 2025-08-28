<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            // Verifica si la columna 'stock' existe antes de intentar eliminarla
            if (Schema::hasColumn('productos', 'stock')) {
                $table->dropColumn('stock');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            // En el método 'down', recreamos la columna 'stock'
            $table->integer('stock')->default(0)->after('precio');
        });
    }
};
