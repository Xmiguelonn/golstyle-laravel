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
        Schema::create('detalle_carrito', function (Blueprint $table) {

            $table->id('cod_det_carr');
            $table->unsignedBigInteger('cod_carr');
            $table->unsignedBigInteger('cod_cam');
            $table->integer('cantidad')->default(1);
            $table->timestamp('fecha_agregado')->useCurrent();

            // CLAVES FORÁNEAS
            $table->foreign('cod_carr')->references('cod_carr')->on('carrito')->cascadeOnDelete();
            $table->foreign('cod_cam')->references('cod_cam')->on('camiseta')->cascadeOnDelete();
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
