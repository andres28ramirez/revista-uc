<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuario_tipo', function (Blueprint $table) {
            Schema::create('usuario_tipo', function (Blueprint $table) {
                $table->id('id_tipo');
                $table->string('nombre',255);
                $table->timestamps();
            });
        });

        DB::table('usuario_tipo')->insert(array(
            array(
                'nombre' => 'Estudiante'
            ),
            array(
                'nombre' => 'Profesor'
            ),
            array(
                'nombre' => 'Administrador'
            ),
        ));
    }

    public function down()
    {
        Schema::dropIfExists('usuario_tipo');
    }
};
