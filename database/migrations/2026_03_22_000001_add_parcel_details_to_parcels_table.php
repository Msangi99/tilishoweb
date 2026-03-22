<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->string('parcel_name')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->string('weight_band', 20)->nullable();
            $table->string('creator_office')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->dropColumn(['parcel_name', 'quantity', 'weight_band', 'creator_office']);
        });
    }
};
