<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelPicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_pics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('TravelId')->default(0)->comment('TravelId');
            $table->string('ImgUrl', 255)->default('')->comment('ImgUrl');
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
        Schema::dropIfExists('travel_pics');
    }
}
