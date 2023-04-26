<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('comentario', function (Blueprint $table) {
            Schema::create('comentario', function (Blueprint $table) {
                $table->id('id_comentario');
                $table->string('estado',255)->default('pendiente');
                $table->string('autor',255);
                $table->text('contenido');
                $table->bigInteger('FK_id_usuario')->nullable()->unsigned();
                $table->bigInteger('FK_id_articulo')->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_usuario')->references('id')->on('users');
                $table->foreign('FK_id_articulo')->references('id_articulo')->on('articulo')->cascadeOnDelete();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('comentario');
    }
};
