<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToAnnualLeave extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('annual_leave', function (Blueprint $table) {
            $table->softDeletes();
            $table->dropColumn('updated_at');
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
            $table->dropColumn('deleted_at');
            $table->dateTime('updated_at')->nullable();
        });
    }
}
