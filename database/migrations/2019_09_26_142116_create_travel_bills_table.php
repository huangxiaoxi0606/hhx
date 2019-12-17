<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('direction_id')->default(0)->comment('方向Id');
            $table->integer('hhx_travel_id')->default(0)->comment('旅行Id');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `travel_bills` comment '旅行账单'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_bills');
    }
}
