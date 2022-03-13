<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('employeeid');
            $table->string('summary');
            $table->text('review');
            $table->text('pros');
            $table->text('cons');
            $table->integer('overall_rating');
            $table->integer('recommend');
            $table->integer('salary_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employer_reviews');
    }
}
