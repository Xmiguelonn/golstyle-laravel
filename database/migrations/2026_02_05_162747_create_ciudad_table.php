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
        Schema::create('ciudad', function (Blueprint $table) {

            $table->id('cod_ciu');
            $table->string('nombre', 50);
            $table->unsignedBigInteger('cod_pro');

            // CLAVES FORÁNEAS
            $table->foreign('cod_pro')->references('cod_pro')->on('provincia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciudad');
    }
};
