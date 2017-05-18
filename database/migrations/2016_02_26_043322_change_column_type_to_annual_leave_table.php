<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypeToAnnualLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('annual_leave', function (Blueprint $table) {
            $table->integer('days')->nullable()->change();
            $table->integer('hours')->nullable()->change();
            $table->integer('minutes')->nullable()->change();
            $table->dateTime('first_day_company')->nullable()->change();
            $table->dateTime('updated_at')->nullable()->change();
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
            //
        });
    }
}
