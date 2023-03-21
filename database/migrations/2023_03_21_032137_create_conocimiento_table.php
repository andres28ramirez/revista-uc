<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('conocimiento', function (Blueprint $table) {
            Schema::create('conocimiento', function (Blueprint $table) {
                $table->id('id_conocimiento');
                $table->string('nombre',255);
                $table->timestamps();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('conocimiento');
    }
};
