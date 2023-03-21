<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notificacion', function (Blueprint $table) {
            Schema::create('notificacion', function (Blueprint $table) {
                $table->id('id_notificacion');
                $table->string('titulo',255);
                $table->text('descripcion');
                $table->bigInteger('id_evento')->nullable();
                $table->bigInteger('FK_id_modulo')->nullable()->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_modulo')->references('id_modulo')->on('modulo');
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificacion');
    }
};
