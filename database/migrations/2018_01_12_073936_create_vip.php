<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userid')->default('null')->nullable(false);
            $table->string('uid')->default('null')->nullable(false);
            $table->string('postid')->default('null')->nullable(false);
            $table->integer('price')->default('0')->nullable(false);
            $table->string('action')->default('null')->nullable(false);
            $table->string('type')->default('null')->nullable(false);
            $table->string('comment')->default('null')->nullable(false);
            $table->string('limit')->default('null')->nullable(false);
            $table->string('time')->default('10')->nullable(false);
            $table->integer('rate')->default('1')->nullable(false);
            $table->integer('active')->default('1')->nullable(false);
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
        Schema::dropIfExists('vip');
    }
}
