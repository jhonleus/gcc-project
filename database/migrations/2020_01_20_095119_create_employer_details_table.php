<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usersId');
            $table->string('company')->nullable();
            $table->unsignedBigInteger('industryId')->nullable();
            $table->unsignedBigInteger('typeId')->nullable();
            $table->string('telephone')->nullable(); 
            $table->string('email')->nullable();
            $table->longText('about_us')->nullable();
            $table->longText('mission_vision')->nullable();
            $table->longText('philosophy')->nullable();
            $table->longText('why_choose')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->unsignedBigInteger('paymentId')->nullable();
            $table->unsignedBigInteger('subscriptionId')->nullable();
            $table->unsignedBigInteger('subscriptionDetailsId')->nullable();
            $table->boolean('isActive')->default(0);
            $table->boolean('isComplete')->default(0);
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
        Schema::dropIfExists('employer_details');
    }
}
