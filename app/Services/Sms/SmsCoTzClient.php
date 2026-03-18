<?php

namespace App\Services\Sms;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsCoTzClient
{
    public function send(string $destination, string $message): ?string
    {
        $enabled = (bool) ((int) SystemSetting::getValue('sms_enabled', 0));
        if (! $enabled) {
            return null;
        }

        $apiKey = (string) SystemSetting::getValue('sms_api_key', '');
        $senderId = (string) SystemSetting::getValue('sms_sender_id', '');

        if (! $apiKey || ! $senderId) {
            Log::warning('SMSCO not configured; skipping SMS send.');
            return null;
        }

        $dest = $this->normalizePhone($destination);
        if (! $dest) {
            Log::warning('Invalid destination phone; skipping SMS.', ['destination' => $destination]);
            return null;
        }

        $response = Http::timeout(12)->get('https://www.sms.co.tz/api.php', [
            'do' => 'sms',
            'api_key' => $apiKey,
            'senderid' => $senderId,
            'dest' => $dest,
            'msg' => $message,
        ]);

        if (! $response->ok()) {
            Log::warning('SMSCO HTTP error', ['status' => $response->status(), 'body' => $response->body()]);
            return null;
        }

        $body = trim($response->body());
        $parts = array_map('trim', explode(',', $body));
        $status = $parts[0] ?? null;

        if ($status !== 'OK') {
            Log::warning('SMSCO send failed', ['response' => $body]);
            return null;
        }

        // OK,<detail>,<id>
        return $parts[2] ?? null;
    }

    private function normalizePhone(string $phone): ?string
    {
        $p = preg_replace('/\D+/', '', $phone) ?? '';

        if ($p === '') {
            return null;
        }

        if (str_starts_with($p, '255')) {
            return $p;
        }

        if (str_starts_with($p, '0') && strlen($p) === 10) {
            return '255'.substr($p, 1);
        }

        if (strlen($p) === 9) {
            return '255'.$p;
        }

        return null;
    }
}

