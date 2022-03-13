<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usersId');
            $table->string('title');
            $table->unsignedBigInteger('employmentId');
            $table->unsignedBigInteger('positionId');
            $table->unsignedBigInteger('locationId');
            $table->string('locationCity');
            $table->unsignedBigInteger('specializationId');
            $table->unsignedBigInteger('currencyId');
            $table->integer('max');
            $table->integer('min');
            $table->longText('description');
            $table->longText('responsibilities');
            $table->longText('qualification');
            $table->boolean('isActive')->default(1);
            $table->boolean('isDeleted')->default(0);
            $table->boolean('isValidate')->default(0);
            $table->text('jobOrder');
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
        Schema::dropIfExists('employer_jobs');
    }
}
