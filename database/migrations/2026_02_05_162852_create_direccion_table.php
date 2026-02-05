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
        Schema::create('direccion', function (Blueprint $table) {

            $table->id('cod_dir');
            $table->string('calle', 100);
            $table->string('num', 10);
            $table->string('piso', 10)->nullable();
            $table->string('cp', 10);
            $table->unsignedBigInteger('cod_usu');
            $table->unsignedBigInteger('cod_ciu');

            // CLAVER FORÁNEAS
            $table->foreign('cod_usu')->references('cod_usu')->on('usuario');
            $table->foreign('cod_ciu')->references('cod_ciu')->on('ciudad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccion');
    }
};
