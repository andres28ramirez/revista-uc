<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuario_rol', function (Blueprint $table) {
            Schema::create('usuario_rol', function (Blueprint $table) {
                $table->id('id_usuario_rol');
                $table->bigInteger('FK_id_usuario')->unsigned();
                $table->bigInteger('FK_id_rol')->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_usuario')->references('id')->on('users')->cascadeOnDelete();;
                $table->foreign('FK_id_rol')->references('id_rol')->on('rol');
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario_rol');
    }
};
