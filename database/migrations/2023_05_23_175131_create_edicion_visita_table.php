<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('edicion_visita', function (Blueprint $table) {
            Schema::create('edicion_visita', function (Blueprint $table) {
                $table->id('id_edicion_visita');
                $table->string('mes',255);
                $table->string('year',255);
                $table->integer('total');
                $table->bigInteger('FK_id_edicion')->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_edicion')->references('id_edicion')->on('edicion')->cascadeOnDelete();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('edicion_visita');
    }
};
