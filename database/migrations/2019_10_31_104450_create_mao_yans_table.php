<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaoYansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mao_yans', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('maoyan_id')->default(0)->comment('豆瓣电影Id');
            $table->string('cover', 255)->default('')->comment('封面链接');
            $table->string('cover_img', 255)->default('')->comment('封面图片');
            $table->string('name', 64)->default('')->comment('名字');
            $table->string('type', 64)->default('')->comment('类型');
            $table->string('date', 32)->default('')->comment('年份');
            $table->string('area', 64)->default('')->comment('地区');
            $table->string('timelong', 64)->default('')->comment('时长');
            $table->string('number', 16)->default('')->comment('票房');
            $table->text('intro')->comment('简介');
            $table->string('rate', 8)->default('')->comment('打分');
            $table->string('url', 255)->default('')->comment('链接');
            $table->string('actor', 512)->default('')->comment('演员');
            $table->string('director', 64)->default('')->comment('导演');
            $table->smallInteger('mold')->default(0)->comment('0正在上映1即将上映2经典影票');

            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `mao_yans` comment '猫眼电影'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mao_yans');
    }
}
