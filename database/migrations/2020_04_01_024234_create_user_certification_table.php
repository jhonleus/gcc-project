<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCertificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_certification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usersId');
            $table->string('type');
            $table->string('number');
            $table->string('accreditor');
            $table->datetime('date_issued');

            $table->string('path');
            $table->string('filename');
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
        Schema::dropIfExists('user_certification');
    }
}
