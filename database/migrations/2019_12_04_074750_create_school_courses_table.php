<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId');
            $table->string('course');
            $table->text('details');

            $table->integer('locationId');
            $table->integer('currencyId');
            $table->string('fee');

            $table->dateTime('class_start');
            $table->dateTime('class_end');
            $table->dateTime('registration_end');

            $table->integer('isActive')->default(1);
            $table->integer('isDeleted')->default(0);
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
        Schema::dropIfExists('school_courses');
    }
}
