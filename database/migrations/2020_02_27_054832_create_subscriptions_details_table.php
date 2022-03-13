<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId')->nullable();
            $table->integer('subscriptionId')->nullable();
            $table->string('subscription_code')->nullable();
            $table->dateTime('first_day')->nullable();
            $table->dateTime('last_day')->nullable();
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
        Schema::dropIfExists('subscriber_details');
    }
}
