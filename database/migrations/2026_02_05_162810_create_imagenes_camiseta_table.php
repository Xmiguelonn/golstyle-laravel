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
        Schema::create('imagenes_camiseta', function (Blueprint $table) {

            $table->id('cod_img');
            $table->unsignedBigInteger('cod_cam');
            $table->longText('imagen');

            // CLAVES FORÁNEAS
            $table->foreign('cod_cam')->references('cod_cam')->on('camiseta')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes_camiseta');
    }
};
