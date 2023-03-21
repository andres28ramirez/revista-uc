<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(array(
            array(
                'name' => 'Super Admin',
                'email' => 'revistaucadm@gmail.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('revistauc2023'),
            )
        ));
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
