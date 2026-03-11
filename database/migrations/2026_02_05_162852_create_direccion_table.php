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
            $table->unsignedBigInteger('cod_dir')->autoIncrement();
            $table->string('nombre', 100); // ← NUEVO CAMPO
            $table->string('calle', 100);
            $table->string('num', 10);
            $table->string('piso', 10)->nullable();
            $table->string('cp', 10);
            $table->string('telefono', 20);
            $table->string('ciudad', 100);
            $table->string('provincia', 100);

            $table->unsignedBigInteger('cod_usu');
            $table->unique(['cod_usu', 'nombre']);


            // CLAVES FORÁNEAS
            $table->foreign('cod_usu')->references('cod_usu')->on('usuario')->cascadeOnDelete();
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
