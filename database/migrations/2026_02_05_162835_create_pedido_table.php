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

            // CLAVER FORÁNEAS
            $table->foreign('cod_usu')->references('cod_usu')->on('usuario');
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
