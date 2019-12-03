<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeenMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seen_movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->default('')->comment('电影名字');
            $table->smallInteger('mold')->default(0)->comment('观看方式0电影院1网络');
            $table->decimal('money', 10, 2)->default(0.0)->comment("金额");
            $table->dateTime('show_time')->comment('观看时间');
            $table->string('note', 64)->default('')->comment('备注');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `seen_movies` comment '已看电影'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seen_movies');
    }
}
