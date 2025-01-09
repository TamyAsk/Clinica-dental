<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id'); // ID del paciente
            $table->unsignedBigInteger('dentista_id'); // ID del dentista
            $table->date('fecha');
            $table->time('hora'); // Fecha y hora de la cita
            $table->text('descripcion'); // Descripción de la cita
            $table->timestamps();

            // Relación con la tabla de usuarios
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('dentista_id')->references('id')->on('dentista')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
