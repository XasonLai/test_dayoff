<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckToCompensatoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compensatory', function (Blueprint $table) {
            $table->integer('check')->after('user_id')->default('0')->unsigned();
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
            $table->dropColumn('check');
        });
    }
}
