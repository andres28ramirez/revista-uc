<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('edicion', function (Blueprint $table) {
            Schema::create('edicion', function (Blueprint $table) {
                $table->id('id_edicion');
                $table->string('titulo',255);
                $table->text('descripcion');
                $table->text('ruta_imagen_es')->nullable();
                $table->text('ruta_imagen_en')->nullable();
                $table->timestamps();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('edicion');
    }
};
