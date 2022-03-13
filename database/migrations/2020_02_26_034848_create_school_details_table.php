<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId');
            $table->string('school');
            $table->unsignedBigInteger('typeId');
            $table->string('telephone');
            $table->string('email');
            $table->longText('about_us');
            $table->longText('mission_vision');
            $table->longText('philosophy');
            $table->longText('why_choose');
            $table->longText('website')->nullable();
            $table->longText('facebook')->nullable();
            $table->longText('twitter')->nullable();
            $table->integer('isActive');
            $table->integer('isComplete');
            $table->integer('subscriptionDetailsId')->nullable();
            $table->integer('subscriptionId')->nullable();
            $table->integer('paymentId')->nullable();
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
        Schema::dropIfExists('school_details');
    }
}
