<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriberBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_branch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId');
            $table->string('branch_name');
            $table->integer('countryId');
            $table->string('city');
            $table->string('street');
            $table->string('zipcode');
            $table->string('number');
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
        Schema::dropIfExists('subscriber_branch');
    }
}
