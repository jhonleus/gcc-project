<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolCourseSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_course_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('usersId');
            $table->string('courseId');
            $table->string('day');
            $table->string('time');
            $table->text('array');
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
        Schema::dropIfExists('school_course_schedules');
    }
}
