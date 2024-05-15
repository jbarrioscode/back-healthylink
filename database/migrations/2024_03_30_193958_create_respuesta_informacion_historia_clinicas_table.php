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
        Schema::create('minv_respuesta_informacion_historia_clinicas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('fecha')->nullable();
            $table->text('respuesta');
            $table->string('unidad')->nullable();
            $table->string('tipo_imagen')->nullable();
            $table->text('observacion')->nullable();
            $table->unsignedBigInteger('minv_formulario_id');
            $table->foreign('minv_formulario_id')->references('id')->on('minv_formulario_muestras');
            $table->unsignedBigInteger('pregunta_id');
            $table->foreign('pregunta_id')->references('id')->on('minv_pregunta_historia_clinicas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minv_respuesta_informacion_historia_clinicas');
    }
};
