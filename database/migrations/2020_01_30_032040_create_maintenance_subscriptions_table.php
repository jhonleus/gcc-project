<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('plan_name')->nullable();
            $table->double('price',5,2)->nullable();
            $table->integer('limit')->nullable();
            $table->integer('expiration')->nullable();
            $table->boolean('check_limit')->default(0);
            $table->boolean('check_reserve')->default(0);
            $table->boolean('check_technical')->default(0);
            $table->boolean('check_email')->default(0);
            $table->boolean('check_applicant')->default(0);
            $table->boolean('check_profile')->default(0);
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
        Schema::dropIfExists('maintenance_subscriptions');
    }
}
