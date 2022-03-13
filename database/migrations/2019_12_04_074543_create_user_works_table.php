<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_works', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usersId');
            $table->unsignedBigInteger('countryId');
            $table->string('company');
            $table->string('dateStart');
            $table->string('dateEnd');
            $table->string('position');
            $table->longText('jobResponsibly');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_works');
    }
}
