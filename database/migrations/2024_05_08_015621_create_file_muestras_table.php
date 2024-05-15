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
        Schema::create('file_muestras', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('filename');
            $table->string('mime');
            $table->string('path');
            $table->integer('size');
            $table->unsignedBigInteger('minv_formulario_id');
            $table->foreign('minv_formulario_id')->references('id')->on('minv_formulario_muestras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_muestras');
    }
};
