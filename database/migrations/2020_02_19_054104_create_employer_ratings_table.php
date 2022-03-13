<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('employer_id');
            $table->integer('work_environment_rate');
            $table->integer('career_growth_rate');
            $table->integer('job_security_rate');
            $table->integer('employee_relation_rate');
            $table->integer('overall_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employer_ratings');
    }
}
