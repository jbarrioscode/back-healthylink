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
        Schema::create('pacientes', function (Blueprint $table) {

            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('tipo_doc');
            $table->string('numero_documento');
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido');
            $table->date('fecha_nacimiento');
            $table->date('fecha_expedicion')->nullable();
            $table->unsignedBigInteger('ciudad_municipio_id');
            $table->foreign('ciudad_municipio_id')->references('id')->on('ciudades_municipios');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
