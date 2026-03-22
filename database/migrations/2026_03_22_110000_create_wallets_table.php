<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->decimal('system', 14, 2)->default(0);
            $table->decimal('tra', 14, 2)->default(0);
            $table->decimal('developer', 14, 2)->default(0);
            $table->timestamps();
        });

        $setting = fn (string $key, string $default): float => (float) (DB::table('system_settings')->where('key', $key)->value('value') ?? $default);

        $traPct = $setting('fee_tra_percent', '18');
        $devPct = $setting('fee_developer_percent', '3');
        $parcelSum = (float) (DB::table('parcels')->sum('amount') ?? 0);

        $traAccrued = round($parcelSum * ($traPct / 100), 2);
        $developerAccrued = round($parcelSum * ($devPct / 100), 2);
        $systemAccrued = round($parcelSum - $traAccrued - $developerAccrued, 2);

        $traWithdrawn = (float) (DB::table('fee_withdrawals')->where('type', 'tra')->sum('amount') ?? 0);
        $developerWithdrawn = (float) (DB::table('fee_withdrawals')->where('type', 'developer')->sum('amount') ?? 0);

        DB::table('wallets')->insert([
            'system' => max(0, $systemAccrued),
            'tra' => max(0, round($traAccrued - $traWithdrawn, 2)),
            'developer' => max(0, round($developerAccrued - $developerWithdrawn, 2)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
