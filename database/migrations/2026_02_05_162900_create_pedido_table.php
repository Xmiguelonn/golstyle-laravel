<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedido', function (Blueprint $table) {

            $table->id('cod_ped');
            $table->date('fecha');
            $table->decimal('total', 10, 2);
            $table->string('estado', 20);
            $table->unsignedBigInteger('cod_usu');
            $table->unsignedBigInteger('cod_dir');

            // CLAVES FORÁNEAS
            $table->foreign('cod_usu')->references('cod_usu')->on('usuario')->cascadeOnDelete();
            $table->foreign('cod_dir')->references('cod_dir')->on('direccion')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido');
    }
};
