<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Créer la nouvelle table reservations avec la colonne modifiée
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Foreign key for car
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');

            // Dates and pricing
            $table->date('start_date')->index();
            $table->date('end_date')->index();
            $table->integer('days');
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('total_price', 10, 2);

            // Delivery and return times
            $table->time('delivery_time')->nullable(); // Nouveau champ ajouté
            $table->time('return_time')->nullable();   // Nouveau champ ajouté

            // Status and payment
            $table->enum('status', ['active', 'completed', 'canceled'])->default('active');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();

            // Personal information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nationality');
            $table->string('identity_number'); // Nouveau champ modifié
            $table->string('drivers_license_number');
            $table->string('address');
            $table->string('mobile_number', 15);

            // File uploads stored as JSON (4 images: identity card front, identity card back, license front, license back)
            $table->json('gallery')->nullable(); // Store file paths or URLs for 4 images

            // Timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        // Supprimer la table si la migration est annulée
        Schema::dropIfExists('reservations');
    }
};

