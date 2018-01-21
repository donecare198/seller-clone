<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('null')->nullable(false);
            $table->string('email')->unique()->default('null')->nullable(false);
            $table->string('fbid')->unique()->default('null')->nullable(false);
            $table->integer('money')->default('0')->nullable(false);
            $table->string('status')->default('null')->nullable(false);
            $table->string('type')->default('null')->nullable(false);
            $table->string('level')->default('null')->nullable(false);
            $table->string('avatar')->default('null')->nullable(false);
            $table->string('access_token')->default('null')->nullable(false);
            $table->string('magioithieu')->default('0')->nullable(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
