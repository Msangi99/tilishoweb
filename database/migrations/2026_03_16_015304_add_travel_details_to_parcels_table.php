<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->foreignId('scanned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('bus_id')->nullable()->constrained('buses')->onDelete('set null');
            $table->date('travel_date')->nullable();
            $table->time('start_travel_time')->nullable();
            $table->time('end_travel_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->dropForeign(['scanned_by']);
            $table->dropForeign(['bus_id']);
            $table->dropColumn(['scanned_by', 'bus_id', 'travel_date', 'start_travel_time', 'end_travel_time']);
        });
    }
};
