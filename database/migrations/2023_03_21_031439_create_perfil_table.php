<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('perfil', function (Blueprint $table) {
            Schema::create('perfil', function (Blueprint $table) {
                $table->id('id_perfil');
                $table->string('nombre',255);
                $table->string('apellido',255);
                $table->text('direccion')->nullable();
                $table->string('telefono',255)->nullable();
                $table->bigInteger('FK_id_usuario')->unsigned();
                $table->bigInteger('FK_id_tipo')->nullable()->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_usuario')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('FK_id_tipo')->references('id_tipo')->on('usuario_tipo');
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfil');
    }
};
