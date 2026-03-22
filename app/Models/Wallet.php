<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Wallet extends Model
{
    protected $fillable = [
        'system',
        'tra',
        'developer',
    ];

    protected function casts(): array
    {
        return [
            'system' => 'decimal:2',
            'tra' => 'decimal:2',
            'developer' => 'decimal:2',
        ];
    }

    public static function instance(): self
    {
        $row = static::query()->first();
        if ($row) {
            return $row;
        }

        return static::query()->create([
            'system' => 0,
            'tra' => 0,
            'developer' => 0,
        ]);
    }

    /**
     * Credit wallets from a parcel: system gets the full parcel amount; TRA and developer get their
     * percentage shares in parallel (not deducted from the system bucket).
     *
     * @param  int  $direction  1 = credit on create, -1 = reverse on delete
     */
    public static function adjustForParcelAmount(float $amount, int $direction = 1): void
    {
        if ($amount <= 0 || ! in_array($direction, [-1, 1], true)) {
            return;
        }

        $traPct = (float) SystemSetting::getValue('fee_tra_percent', '18');
        $devPct = (float) SystemSetting::getValue('fee_developer_percent', '3');
        $traPart = round($amount * ($traPct / 100), 2);
        $devPart = round($amount * ($devPct / 100), 2);
        $sysPart = round($amount, 2);

        $delta = $direction;

        DB::transaction(function () use ($traPart, $devPart, $sysPart, $delta) {
            $wallet = static::query()->lockForUpdate()->first();
            if (! $wallet) {
                static::query()->create([
                    'system' => 0,
                    'tra' => 0,
                    'developer' => 0,
                ]);
                $wallet = static::query()->lockForUpdate()->first();
            }

            $wallet->system = round((float) $wallet->system + ($sysPart * $delta), 2);
            $wallet->tra = round((float) $wallet->tra + ($traPart * $delta), 2);
            $wallet->developer = round((float) $wallet->developer + ($devPart * $delta), 2);
            $wallet->save();
        });
    }

    /**
     * Decrement TRA or developer balance. Call inside DB::transaction with lockForUpdate.
     *
     * @throws ValidationException
     */
    public static function debitForWithdrawal(string $type, float $amount): void
    {
        if ($amount <= 0) {
            return;
        }

        $column = $type === FeeWithdrawal::TYPE_TRA ? 'tra' : 'developer';

        $wallet = static::query()->lockForUpdate()->first();
        if (! $wallet) {
            static::query()->create([
                'system' => 0,
                'tra' => 0,
                'developer' => 0,
            ]);
            $wallet = static::query()->lockForUpdate()->first();
        }

        $balance = (float) $wallet->$column;
        if ($balance + 0.0001 < $amount) {
            throw ValidationException::withMessages([
                'withdrawAmount' => 'Withdrawal amount exceeds current wallet balance for this bucket.',
            ]);
        }

        $wallet->$column = round($balance - $amount, 2);
        $wallet->save();
    }
}
