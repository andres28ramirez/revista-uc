<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuario_notificacion', function (Blueprint $table) {
            Schema::create('usuario_notificacion', function (Blueprint $table) {
                $table->id('id_usuario_notificacion');
                $table->timestamp('read_at')->nullable();
                $table->bigInteger('FK_id_user')->unsigned();
                $table->bigInteger('FK_id_notificacion')->unsigned();
                $table->timestamps();

                $table->foreign('FK_id_user')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('FK_id_notificacion')->references('id_notificacion')->on('notificacion')->cascadeOnDelete();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario_notificacion');
    }
};
