<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionWayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provision_way', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provision_id')->unsigned();
            $table->integer('limit_hours')->unsigned();
            $table->string('name',100);
            $table->string('suggest',100);
            $table->string('proof',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('provision_way');
    }
}
