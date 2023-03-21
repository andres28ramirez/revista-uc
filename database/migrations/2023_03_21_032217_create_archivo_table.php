<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('archivo', function (Blueprint $table) {
            Schema::create('archivo', function (Blueprint $table) {
                $table->id('id_archivo');
                $table->string('nombre',255);
                $table->string('ruta_archivo_es',255)->nullable();
                $table->string('ruta_archivo_en',255)->nullable();
                $table->string('tipo',255)->nullable();
                $table->bigInteger('FK_id_articulo')->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_articulo')->references('id_articulo')->on('articulo')->cascadeOnDelete();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('archivo');
    }
};
