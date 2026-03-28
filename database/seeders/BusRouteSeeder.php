<?php

namespace Database\Seeders;

use App\Models\BusRoute;
use App\Models\Bus;
use Illuminate\Database\Seeder;

class BusRouteSeeder extends Seeder
{
    /**
     * Seed sample bus routes (and optional buses) so the app has data.
     */
    public function run(): void
    {
        $routes = [
            ['from' => 'Dar es Salaam', 'to' => 'Arusha'],
            ['from' => 'Dar es Salaam', 'to' => 'Mwanza'],
            ['from' => 'Dar es Salaam', 'to' => 'Mbeya'],
            ['from' => 'Arusha', 'to' => 'Moshi'],
            ['from' => 'Mwanza', 'to' => 'Dar es Salaam'],
        ];

        foreach ($routes as $r) {
            BusRoute::firstOrCreate(
                ['from' => $r['from'], 'to' => $r['to']],
                []
            );
        }

        // Optionally add a sample bus if none exist and we have a route
        $route = BusRoute::first();
        if ($route && Bus::count() === 0) {
            Bus::firstOrCreate(
                ['plate_number' => 'T 123 ABC'],
                [
                    'model' => 'Coaster',
                    'capacity' => 30,
                    'status' => 'active',
                    'route_id' => $route->id,
                ]
            );
        }
    }
}
