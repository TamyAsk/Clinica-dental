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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_cat_usuarios')->nullable();
            $table->foreign('fk_cat_usuarios')->references('pk_cat_usuarios')->on('cat_usuarios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['fk_cat_usuario']);
            $table->dropColumn('fk_cat_usuario');
        });
    }
};
