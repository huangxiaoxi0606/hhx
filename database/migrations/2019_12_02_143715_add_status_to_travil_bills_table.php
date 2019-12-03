<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToTravilBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travil_bills', function (Blueprint $table) {
            $table->smallInteger('status')->default(0)->comment('0形程未结束1行程结束');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travil_bills', function (Blueprint $table) {
            //
        });
    }
}
