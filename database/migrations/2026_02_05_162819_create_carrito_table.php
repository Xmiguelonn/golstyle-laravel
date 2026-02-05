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
        Schema::create('carrito', function (Blueprint $table) {

            $table->id('cod_carr');
            $table->unsignedBigInteger('cod_usu');
            $table->timestamp('fecha_creacion')->useCurrent();

            // CLAVES FORÁNEAS
            $table->foreign('cod_usu')->references('cod_usu')->on('usuario')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito');
    }
};
