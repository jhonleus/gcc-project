<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagecontentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagecontents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('head');
            $table->string('picture1');
            $table->string('picture2');
            $table->string('login');
            $table->string('register');
            $table->string('feedback');
            $table->string('contact');
            $table->string('url')->nullable();
            $table->boolean('users')->default(1);
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
        Schema::dropIfExists('pagecontents');
    }
}
