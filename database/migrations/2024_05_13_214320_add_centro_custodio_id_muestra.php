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
        Schema::table('temp_muestras_boxes', function (Blueprint $table) {
            $table->unsignedBigInteger('ubicacion_bio_bancos_id');
            $table->foreign('ubicacion_bio_bancos_id')->references('id')->on('ubicacion_bio_bancos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_muestras_boxes', function (Blueprint $table) {
          $table->dropColumn('ubicacion_bio_bancos_id');
        });
    }
};
