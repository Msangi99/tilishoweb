<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        return Cache::remember("system_setting:{$key}", 300, function () use ($key, $default) {
            $value = self::where('key', $key)->value('value');
            return $value !== null ? $value : $default;
        });
    }

    public static function setValue(string $key, mixed $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("system_setting:{$key}");
    }
}
