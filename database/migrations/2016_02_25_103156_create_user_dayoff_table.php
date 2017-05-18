<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDayoffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_dayoff', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('staff_id')->unsigned();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->integer('check')->unsigned();
            $table->integer('days')->unsigned();
            $table->integer('hours')->unsigned();
            $table->integer('minutes')->unsigned();
            $table->string('agent_name',100);
            $table->integer('provision_id')->unsigned();
            $table->integer('provision_way_id')->unsigned();
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
        Schema::drop('user_dayoff');
    }
}
