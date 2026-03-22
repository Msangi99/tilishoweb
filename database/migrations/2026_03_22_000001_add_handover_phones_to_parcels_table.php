<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->string('transported_by_phone', 30)->nullable()->after('transported_by_name');
            $table->string('received_by_phone', 30)->nullable()->after('received_by_name');
        });
    }

    public function down(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->dropColumn(['transported_by_phone', 'received_by_phone']);
        });
    }
};
