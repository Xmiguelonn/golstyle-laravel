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
        Schema::create('variantes_camiseta', function (Blueprint $table) {
            $table->unsignedBigInteger('cod_var')->autoIncrement();
            $table->unsignedBigInteger('cod_cam');
            $table->string('talla', 5);
            $table->integer('stock')->default(0);

            // CLAVES FORÁNEAS
            $table->foreign('cod_cam')->references('cod_cam')->on('camiseta')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variantes_camiseta');
    }
};
