<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rol', function (Blueprint $table) {
            Schema::create('rol', function (Blueprint $table) {
                $table->id('id_rol');
                $table->string('nombre',255);
                $table->timestamps();
            });
        });

        DB::table('rol')->insert(array(
            array(
                'nombre' => 'Administrador'
            ),
            array(
                'nombre' => 'Moderador'
            ),
            array(
                'nombre' => 'Editor'
            ),
            array(
                'nombre' => 'Usuario'
            ),
        ));
    }

    public function down()
    {
        Schema::dropIfExists('rol');
    }
};
