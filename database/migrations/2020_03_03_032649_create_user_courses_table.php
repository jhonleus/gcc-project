<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_courses_application', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId');
            $table->integer('courseId');
            $table->integer('companyId');
            $table->string('path');
            $table->string('certificate');
            $table->string('records');
            $table->integer('status');
            $table->integer('isActive');
            $table->text('message')->nullable();
            $table->dateTime('schedule_date')->nullable();
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
        Schema::dropIfExists('user_courses_application');
    }
}
