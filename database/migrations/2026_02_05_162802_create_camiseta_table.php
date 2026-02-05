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
        Schema::create('camiseta', function (Blueprint $table) {

            $table->id('cod_cam');
            $table->string('color', 30);
            $table->unsignedBigInteger('cod_equi')->nullable();
            $table->unsignedBigInteger('cod_sel')->nullable();
            $table->unsignedBigInteger('cod_tem');
            $table->longText('imagen_principal')->nullable();

            // CLAVES FORÁNEAS
            $table->foreign('cod_equi')->references('cod_equi')->on('equipo');
            $table->foreign('cod_sel')->references('cod_sel')->on('seleccion');
            $table->foreign('cod_tem')->references('cod_tem')->on('temporada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camiseta');
    }
};
