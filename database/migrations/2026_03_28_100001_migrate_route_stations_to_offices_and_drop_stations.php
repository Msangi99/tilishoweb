<?php

use App\Models\BusRoute;
use App\Models\Office;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('offices') || ! Schema::hasColumn('bus_routes', 'stations')) {
            return;
        }

        foreach (BusRoute::query()->cursor() as $route) {
            $raw = (string) ($route->stations ?? '');
            foreach (explode(',', $raw) as $part) {
                $name = trim($part);
                if ($name !== '') {
                    Office::firstOrCreate(['name' => $name]);
                }
            }
        }

        Schema::table('bus_routes', function (Blueprint $table) {
            $table->dropColumn('stations');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('bus_routes')) {
            return;
        }

        if (! Schema::hasColumn('bus_routes', 'stations')) {
            Schema::table('bus_routes', function (Blueprint $table) {
                $table->text('stations')->nullable();
            });
        }
    }
};
