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
        Schema::create('usuario', function (Blueprint $table) {
            
            $table->id('cod_usu');
            $table->string('nombre', 50);
            $table->string('ape1', 50);
            $table->string('ape2', 50)->nullable();
            $table->string('correo', 100)->unique();
            $table->string('password', 255);
            $table->string('telefono', 20)->nullable();
            $table->string('rol', 50)->default('usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
