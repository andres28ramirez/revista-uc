<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulo_autores', function (Blueprint $table) {
            Schema::create('articulo_autores', function (Blueprint $table) {
                $table->id('id_articulo_autores');
                $table->bigInteger('FK_id_articulo')->nullable()->unsigned();
                $table->bigInteger('FK_id_autor')->nullable()->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_articulo')->references('id_articulo')->on('articulo')->cascadeOnDelete();
                $table->foreign('FK_id_autor')->references('id_autor')->on('autor')->cascadeOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulo_autores');
    }
};
