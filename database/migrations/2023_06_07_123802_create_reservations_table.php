<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');

            // Dates and pricing
            $table->date('start_date')->index();
            $table->date('end_date')->index();
            $table->integer('days');
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('total_price', 10, 2);

            // Status and payment
            $table->enum('status', ['active', 'completed', 'canceled'])->default('active');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();

            // Personal information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nationality');
            $table->string('identity_card_number'); // Corrigé
            $table->string('driver_license_number');
            $table->string('address');
            $table->string('mobile_number', 15);

            // File uploads stored as JSON
            $table->json('gallery')->nullable();

            // Additional data
            $table->time('delivery_time');
            $table->time('return_time');

            // Timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
