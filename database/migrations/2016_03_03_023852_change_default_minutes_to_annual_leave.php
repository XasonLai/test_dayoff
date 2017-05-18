<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDefaultMinutesToAnnualLeave extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('annual_leave', function (Blueprint $table) {
            $table->integer('days')->unsigned()->default(0)->change();
            $table->integer('hours')->unsigned()->default(0)->change();
            $table->integer('minutes')->unsigned()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('annual_leave', function (Blueprint $table) {

        });
    }
}
