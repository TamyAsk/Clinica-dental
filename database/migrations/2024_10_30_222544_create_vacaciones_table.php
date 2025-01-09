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
        Schema::create('vacaciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio'); 
            $table->date('fecha_fin'); 
            $table->text('motivo'); // Sin nullable() y sin default()
            $table->unsignedBigInteger('dentista_id');
            $table->timestamps();

            $table->foreign('dentista_id')->references('id')->on('dentista')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacaciones');
    }
};
