<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userid')->default('0')->nullable(false);
            $table->string('money')->default('null')->nullable(false);
            $table->string('note')->default('null')->nullable(false);
            $table->string('status')->default('pendding')->nullable(false);
            $table->string('admin')->default('null')->nullable(false);
            $table->string('transactionid')->default('null')->nullable(false);
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
        Schema::dropIfExists('transaction');
    }
}
