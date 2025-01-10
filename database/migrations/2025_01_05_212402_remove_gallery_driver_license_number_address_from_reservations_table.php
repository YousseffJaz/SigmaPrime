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
    Schema::table('reservations', function (Blueprint $table) {
        // Remove the columns
        $table->dropColumn('gallery');
        $table->dropColumn('driver_license_number');
       
    });
}

public function down()
{
    Schema::table('reservations', function (Blueprint $table) {
        // Revert the changes (if needed, add column types)
        $table->string('gallery')->nullable();
        $table->string('driver_license_number')->nullable();
        
    });
}

};
