<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo')->default('LikePro')->nullable(false);
            $table->string('logo-mini')->default('LPV')->nullable(false);
            $table->string('copyright')->default('LikePro')->nullable(false);
            $table->string('powered')->default('0')->nullable(false);
            $table->string('ctk')->default('0')->nullable(false);
            $table->string('stk')->default('0')->nullable(false);
            $table->string('nganhang')->default('0')->nullable(false);
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
