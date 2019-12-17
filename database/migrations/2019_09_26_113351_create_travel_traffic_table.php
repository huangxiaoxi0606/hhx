<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_traffic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('img', 255)->default('')->comment('图片');
            $table->string('name', 32)->default('')->comment('名字');
            $table->string('illustrate', 255)->default('')->comment('说明');
            $table->decimal('money', 10, 2)->default(0.0)->comment("金额");
            $table->smallInteger('ok')->default(0)->comment('0ok1bad');
            $table->date('travel_at')->comment('出发日期');
            $table->smallInteger('status')->default(0)->comment('0未出发1已出发');
            $table->integer('direction_id')->default(0)->comment('方向Id');
            $table->integer('daily_id')->default(0)->comment('日常Id');
            $table->integer('hhx_travel_id')->default(0)->comment('旅行Id');

            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `travel_traffic` comment '旅行交通'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_traffic');
    }
}
