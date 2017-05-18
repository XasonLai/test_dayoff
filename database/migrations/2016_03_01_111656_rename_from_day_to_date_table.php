<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFromDayToDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compensatory', function (Blueprint $table) {
            $table->dropColumn('day');
            $table->dropColumn('date_start');
            $table->dropColumn('date_end');
            $table->date('date')->after('minute');
            $table->time('time_start');
            $table->time('time_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compensatory', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('time_start');
            $table->dropColumn('time_end');
            $table->integer('day')->unsigned();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
        });
    }
}
