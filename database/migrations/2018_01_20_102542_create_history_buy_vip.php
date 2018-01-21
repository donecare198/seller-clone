<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryBuyVip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_buy_vip', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userid')->default('0')->nullable(false);
            $table->string('money')->default('null')->nullable(false);
            $table->string('vipid')->default('null')->nullable(false);
            $table->string('time')->default('0')->nullable(false);
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
        Schema::dropIfExists('history_buy_vip');
    }
}
