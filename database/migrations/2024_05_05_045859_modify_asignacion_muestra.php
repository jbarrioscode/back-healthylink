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
        Schema::table('minv_asignacion_muestra_ubicacion', function (Blueprint $table) {
            $table->dropColumn('ubicacion_estantes_id');
            $table->unsignedBigInteger('caja_nevera_id');
            $table->foreign('caja_nevera_id')->references('id')->on('ubicacion_cajas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minv_asignacion_muestra_ubicacion', function (Blueprint $table) {
            $table->dropColumn('caja_nevera_id');
            $table->unsignedBigInteger('ubicacion_estantes_id');
            $table->foreign('ubicacion_estantes_id')->references('id')->on('ubicacion_estantes');
        });
    }
};
