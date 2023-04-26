<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('respuesta', function (Blueprint $table) {
            Schema::create('respuesta', function (Blueprint $table) {
                $table->id('id_respuesta');
                $table->string('estado',255)->default('pendiente');
                $table->string('nombre',255);
                $table->text('contenido');
                $table->bigInteger('FK_id_usuario')->nullable()->unsigned();
                $table->bigInteger('FK_id_comentario')->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_usuario')->references('id')->on('users');
                $table->foreign('FK_id_comentario')->references('id_comentario')->on('comentario')->cascadeOnDelete();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('respuesta');
    }
};
