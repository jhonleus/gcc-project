<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserJobsResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_jobs_response', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("usersId");
            $table->integer("jobApplicationId");
            $table->dateTime('availability')->nullable();
            $table->integer('isAccept');
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
        Schema::dropIfExists('user_jobs_response');
    }
}
