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
        Schema::create('horario', function (Blueprint $table) {
            $table->id();
            $table->date('dia_semana'); 
            $table->time('hora_inicio'); 
            $table->time('hora_fin'); 
            $table->unsignedBigInteger('dentista_id'); //ID del dentista
            $table->timestamps();

            $table->foreign('dentista_id')->references('id')->on('dentista')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario');
    }
};
