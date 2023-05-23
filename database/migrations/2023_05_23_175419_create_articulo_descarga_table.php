<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articulo_descarga', function (Blueprint $table) {
            Schema::create('articulo_descarga', function (Blueprint $table) {
                $table->id('id_articulo_descarga');
                $table->string('mes',255);
                $table->string('year',255);
                $table->integer('total');
                $table->bigInteger('FK_id_articulo')->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_articulo')->references('id_articulo')->on('articulo')->cascadeOnDelete();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('articulo_descarga');
    }
};
