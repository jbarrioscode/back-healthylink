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
        Schema::create('temp_lotes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('minv_formulario_id');
            $table->foreign('minv_formulario_id')->references('id')->on('minv_formulario_muestras');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes_toma_muestras');
            $table->string('tipo_muestra');
            $table->boolean('lote_cerrado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_lotes');
    }
};
