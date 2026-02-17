<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_carrito', function (Blueprint $table) {

            $table->id('cod_det_carr');

            $table->unsignedBigInteger('cod_carr');
            $table->unsignedBigInteger('cod_var');

            $table->integer('cantidad')->default(1);
            $table->timestamp('fecha_agregado')->useCurrent();

            $table->string('nombre_personalizado', 50)->nullable();
            $table->tinyInteger('dorsal_personalizado')->unsigned()->nullable();

            // CHECK dorsal 0–99
            $table->check('dorsal_personalizado IS NULL OR (dorsal_personalizado >= 0 AND dorsal_personalizado <= 99)');

            // Claves foráneas
            $table->foreign('cod_carr')->references('cod_carr')->on('carrito')
                ->cascadeOnDelete();

            $table->foreign('cod_var')->references('cod_var')->on('variantes_camiseta')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_carrito');
    }
};
