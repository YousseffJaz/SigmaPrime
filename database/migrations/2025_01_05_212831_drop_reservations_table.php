<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::dropIfExists('reservations');
}

public function down()
{
    // If you need to roll back the migration, you can recreate the table
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('car_id');
        $table->string('first_name');
        $table->string('last_name');
        $table->date('start_date');
        $table->date('end_date');
        $table->string('nationality');
        $table->string('identity_card_number');
        $table->string('mobile_number');
        $table->string('gallery')->nullable();
        $table->string('driver_license_number')->nullable();
        $table->string('address')->nullable();
        $table->string('reservation_dates');
        $table->string('delivery_time');
        $table->string('return_time');
        $table->integer('days');
        $table->integer('price_per_day');
        $table->integer('total_price');
        $table->string('status');
        $table->string('payment_method');
        $table->string('payment_status');
        $table->timestamps();
        $table->softDeletes();
    });
}

};
