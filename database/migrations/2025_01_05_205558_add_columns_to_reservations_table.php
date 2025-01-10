<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->json('gallery')->nullable()->after('address');
            $table->date('start_date')->nullable()->after('car_id'); // Ajoute une colonne date
            $table->date('end_date')->nullable()->after('start_date');
            $table->time('delivery_time')->nullable()->after('end_date'); // Ajoute une colonne time
            $table->time('return_time')->nullable()->after('delivery_time');
            
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date', 'delivery_time', 'return_time', 'gallery']);
        });
    }
};
