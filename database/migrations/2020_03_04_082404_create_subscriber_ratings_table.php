<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriberRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId')->nullable();
            $table->integer('companyId');
            $table->integer('environment');
            $table->integer('career_growth');
            $table->integer('security');
            $table->integer('relation');
            $table->integer('fees');
            $table->float('overall');
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
        Schema::dropIfExists('subscriber_ratings');
    }
}
