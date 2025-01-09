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
        Schema::create('paciente', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100); 
            $table->string('apaterno', 100); 
            $table->string('amaterno', 100);
            $table->string('email')->unique();
            $table->string('telefono', 15); 
            $table->string('genero', 10)->nullable();
            $table->string('tipo_sangre', 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente');
    }
};
