<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSuggestTypeToProvisionWayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provision_way', function (Blueprint $table) {
            $table->text('suggest')->change();
            $table->string('name',100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provision_way', function (Blueprint $table) {
            //
        });
    }
}
