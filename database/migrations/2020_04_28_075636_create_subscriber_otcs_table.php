<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriberOtcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_otcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId');
            $table->integer('subscriptionId');
            $table->integer('bankId');
            $table->string('transaction');
            $table->string('name');
            $table->string('date');
            $table->integer('amount');
            $table->string('receipt');
            $table->integer('isActive')->default(0);
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
        Schema::dropIfExists('subscriber_otcs');
    }
}
