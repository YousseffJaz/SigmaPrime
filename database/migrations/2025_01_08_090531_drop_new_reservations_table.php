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
        // Supprime la table reservations
        Schema::dropIfExists('reservations');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Récrée la table reservations
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('car_id');
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('nationality');
            $table->string('identity_card_number');
            $table->string('drivers_license_number');
            $table->string('address');
            $table->string('mobile_number');
            $table->json('gallery')->nullable();
            $table->time('delivery_time');
            $table->time('return_time');
            $table->integer('days');
            $table->decimal('price_per_day', 8, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['active', 'completed', 'canceled'])->default('active');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }
};
