<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('haves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32)->default('')->comment('名字');
            $table->string('intro', 64)->default('')->comment('简述')->nullable();
            $table->string('pic', 255)->default('')->comment('图片')->nullable();
            $table->string('year', 8)->default('')->comment('年份')->nullable();
            $table->smallInteger('mold')->default(0)->comment('分类');
            $table->smallInteger('type')->default(0)->comment('类型');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `haves` comment '拥有'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('haves');
    }
}
