<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuario_permiso', function (Blueprint $table) {
            Schema::create('usuario_permiso', function (Blueprint $table) {
                $table->id('id_usuario_permiso');
                $table->boolean('save')->default(1);
                $table->boolean('update')->default(1);
                $table->boolean('delete')->default(1);
                $table->bigInteger('FK_id_usuario')->unsigned();
                $table->bigInteger('FK_id_modulo')->unsigned();
                $table->timestamps();
                
                $table->foreign('FK_id_usuario')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('FK_id_modulo')->references('id_modulo')->on('modulo')->cascadeOnDelete();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario_permiso');
    }
};
