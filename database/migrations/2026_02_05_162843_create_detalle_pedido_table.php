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
            $table->unsignedBigInteger('cod_cam');

            // CLAVER FORÁNEAS
            $table->foreign('cod_ped')->references('cod_ped')->on('pedido');
            $table->foreign('cod_cam')->references('cod_cam')->on('camiseta');
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
