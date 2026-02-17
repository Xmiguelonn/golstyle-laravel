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
        Schema::create('detalle_pedido', function (Blueprint $table) {

            $table->id('cod_det');

            $table->decimal('precio_unid', 10, 2);
            $table->integer('cantidad');

            $table->unsignedBigInteger('cod_ped');
            $table->unsignedBigInteger('cod_var');

            $table->string('nombre_personalizado', 50)->nullable();
            $table->tinyInteger('dorsal_personalizado')->unsigned()->nullable();

            // CHECK dorsal 0–99
            $table->check('dorsal_personalizado IS NULL OR (dorsal_personalizado >= 0 AND dorsal_personalizado <= 99)');

            // Claves foráneas
            $table->foreign('cod_ped')->references('cod_ped')->on('pedido');
            $table->foreign('cod_var')->references('cod_var')->on('variantes_camiseta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
    }
};
