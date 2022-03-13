<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceBankdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_bankdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->string('account_number')->nullable();;
              $table->string('account_name')->nullable();;
               $table->date('expiration')->nullable();;
                $table->integer('cvv')->nullable();;
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
        Schema::dropIfExists('maintenance_bankdetails');
    }
}
