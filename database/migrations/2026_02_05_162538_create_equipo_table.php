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
        Schema::create('equipo', function (Blueprint $table) {
            
            $table->id('cod_equi');
            $table->string('nombre', 50)->unique();
            $table->unsignedBigInteger('cod_lig');

            // CLAVES FORÁNEAS
            $table->foreign('cod_lig')->references('cod_lig')->on('liga')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo');
    }
};
