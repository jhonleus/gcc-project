<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriberReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId')->nullable();
            $table->integer('companyId');
            $table->string('summary');
            $table->text('review');
            $table->string('pros');
            $table->string('cons');
            $table->integer('rating');
            $table->integer('recommend');
            $table->integer('isActive');
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
        Schema::dropIfExists('subscriber_reviews');
    }
}
