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
            $table->foreignId('transported_by_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('transported_by_name')->nullable();
            $table->foreignId('transported_bus_id')->nullable()->constrained('buses')->onDelete('set null');
            $table->string('transported_route')->nullable();
            $table->timestamp('transported_at')->nullable();

            $table->foreignId('received_by_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('received_by_name')->nullable();
            $table->timestamp('received_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->dropForeign(['transported_by_id']);
            $table->dropForeign(['transported_bus_id']);
            $table->dropForeign(['received_by_id']);

            $table->dropColumn([
                'transported_by_id',
                'transported_by_name',
                'transported_bus_id',
                'transported_route',
                'transported_at',
                'received_by_id',
                'received_by_name',
                'received_at',
            ]);
        });
    }
};

