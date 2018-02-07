<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyclone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyclone', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userid')->default('null')->nullable(false);
            $table->string('soluong')->default('null')->nullable(false);
            $table->string('loai')->default('null')->nullable(false);
            $table->integer('giatien')->default('0')->nullable(false);
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
        //
    }
}
