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
        Schema::create('dentista', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100); 
            $table->string('apaterno', 100); 
            $table->string('amaterno', 100);
            $table->string('email')->unique();
            $table->string('telefono', 15); 
            $table->integer('dias_laborales'); 
            $table->double('estatus', 1);
            $table->unsignedBigInteger('especialidad_id'); // ID del la especialidad
            $table->timestamps();
            

            // Relacion con la tabla especialidad
                 $table->foreign('especialidad_id')->references('id')->on('especialidad')->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dentista');
    }
};
