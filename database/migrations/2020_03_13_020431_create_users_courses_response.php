<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCoursesResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_courses_response', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId');
            $table->integer('courseApplicationId');
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
        Schema::dropIfExists('user_courses_response');
    }
}
