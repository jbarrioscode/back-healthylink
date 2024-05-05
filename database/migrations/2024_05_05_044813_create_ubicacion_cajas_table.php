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
        Schema::create('ubicacion_cajas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('num_caja');
            $table->string('num_fila');
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('nevera_estante_id');
            $table->foreign('nevera_estante_id')->references('id')->on('ubicacion_estantes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicacion_cajas');
    }
};
