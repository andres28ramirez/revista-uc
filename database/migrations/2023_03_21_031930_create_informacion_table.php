<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('informacion', function (Blueprint $table) {
            Schema::create('informacion', function (Blueprint $table) {
                $table->id('id_informacion');
                $table->string('titulo',255);
                $table->string('titulo_en',255);
                $table->text('contenido');
                $table->text('contenido_en');
                $table->text('ruta_archivo')->nullable();
                $table->timestamps();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('informacion');
    }
};
