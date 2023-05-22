<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articulo', function (Blueprint $table) {
            Schema::create('articulo', function (Blueprint $table) {
                $table->id('id_articulo');
                $table->string('titulo',255);
                $table->string('titulo_en',255)->nullable();
                $table->text('contenido');
                $table->text('contenido_en')->nullable();
                $table->text('ruta_imagen_es')->nullable();
                $table->text('ruta_imagen_en')->nullable();
                $table->bigInteger('FK_id_edicion')->unsigned();
                $table->bigInteger('FK_id_autor')->nullable()->unsigned();
                $table->bigInteger('FK_id_conocimiento')->nullable()->unsigned();
                $table->date('publicated_at')->nullable();
                $table->timestamps();

                $table->foreign('FK_id_edicion')->references('id_edicion')->on('edicion')->cascadeOnDelete();
                $table->foreign('FK_id_autor')->references('id_autor')->on('autor');
                $table->foreign('FK_id_conocimiento')->references('id_conocimiento')->on('conocimiento');
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('articulo');
    }
};
