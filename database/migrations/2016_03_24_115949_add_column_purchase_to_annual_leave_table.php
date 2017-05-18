<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPurchaseToAnnualLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('annual_leave', function (Blueprint $table) {
            $table->date('purchase')->after('minutes');
            $table->date('expire_to_day')->after('purchase');
            $table->dropColumn('first_day_company');
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
            $table->dropColumn('purchase');
            $table->dropColumn('expire_to_day');
            $table->date('first_day_company');
        });
    }
}
