<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelEquipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_equips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32)->default('')->comment('名字');
            $table->integer('hhx_travel_id')->default(0)->comment('旅行Id');
            $table->smallInteger('status')->default(0)->comment('0购买1已有2需复查3复查4形成结束5不带');
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
        Schema::dropIfExists('travel_equips');
    }
}
