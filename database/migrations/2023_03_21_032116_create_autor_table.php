<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('autor', function (Blueprint $table) {
            Schema::create('autor', function (Blueprint $table) {
                $table->id('id_autor');
                $table->string('nombre',255);
                $table->string('email',255)->nullable();
                $table->text('grado');
                $table->text('sintesis');
                $table->text('ruta_imagen')->nullable();
                $table->timestamps();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('autor');
    }
};
