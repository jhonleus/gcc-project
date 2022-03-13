
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usersId');         
            $table->unsignedBigInteger('typeId')->nullable();
            $table->double('result', 15, 8)->nullable();
            $table->integer('age')->nullable();
            $table->date('birthDate')->nullable();
            $table->unsignedBigInteger('genderId')->nullable();
            $table->unsignedBigInteger('civilId')->nullable();
            $table->unsignedBigInteger('religionId')->nullable();
            $table->unsignedBigInteger('currencyId')->nullable();
            $table->integer('number')->nullable();
            $table->boolean('isComplete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
