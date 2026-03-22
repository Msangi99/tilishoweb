<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * System wallet should equal total parcel gross; TRA/developer remain % accruals minus withdrawals.
     */
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('wallets')) {
            return;
        }

        $setting = fn (string $key, string $default): float => (float) (DB::table('system_settings')->where('key', $key)->value('value') ?? $default);

        $traPct = $setting('fee_tra_percent', '18');
        $devPct = $setting('fee_developer_percent', '3');
        $parcelSum = (float) (DB::table('parcels')->sum('amount') ?? 0);

        $traAccrued = round($parcelSum * ($traPct / 100), 2);
        $developerAccrued = round($parcelSum * ($devPct / 100), 2);
        $systemAccrued = round($parcelSum, 2);

        $traWithdrawn = (float) (DB::table('fee_withdrawals')->where('type', 'tra')->sum('amount') ?? 0);
        $developerWithdrawn = (float) (DB::table('fee_withdrawals')->where('type', 'developer')->sum('amount') ?? 0);

        DB::table('wallets')->update([
            'system' => max(0, $systemAccrued),
            'tra' => max(0, round($traAccrued - $traWithdrawn, 2)),
            'developer' => max(0, round($developerAccrued - $developerWithdrawn, 2)),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Cannot reliably restore previous split-based system balance.
    }
};
