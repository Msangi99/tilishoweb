<?php

namespace App\Services\Sms;

use App\Models\Parcel;
use Carbon\Carbon;

class ParcelSmsComposer
{
    public function createdForSender(Parcel $parcel): string
    {
        $shipDate = $this->shipDate($parcel);
        $route = strtoupper(($parcel->origin ?? '').' - '.($parcel->destination ?? ''));
        $cargo = $this->cargo($parcel);
        $qty = 1;
        $fare = $this->fare($parcel);

        return trim("TILISHO PARCEL
Hi, {$parcel->sender_name}
{$parcel->tracking_number}
{$route}
recever: {$parcel->receiver_name} - {$parcel->receiver_phone}
Ship Date: {$shipDate}
Cargo: {$cargo}
Qty: ({$qty})
Fare: {$fare}

BOOK US ONLINE
www.tilishosafari.co.tz
DOWNLOAD OUR APP
https://onelink.to/busbora
Msaada:0750015630");
    }

    public function createdForReceiver(Parcel $parcel): string
    {
        $shipDate = $this->shipDate($parcel);
        $route = strtoupper(($parcel->origin ?? '').' - '.($parcel->destination ?? ''));
        $cargo = $this->cargo($parcel);
        $qty = 1;
        $fare = $this->fare($parcel);

        return trim("TILISHO PARCEL
Hi, {$parcel->receiver_name}
{$parcel->tracking_number}
{$route}
Sender: {$parcel->sender_name} - {$parcel->sender_phone}
Ship Date: {$shipDate}
Cargo: {$cargo}
Qty: ({$qty})
Fare: {$fare}

BOOK US ONLINE
www.tilishosafari.co.tz
DOWNLOAD OUR APP
https://onelink.to/busbora
Msaada:0750015630");
    }

    public function receivedNotice(Parcel $parcel): string
    {
        $shipDate = $this->shipDate($parcel);
        $cargo = $this->cargo($parcel);
        $qty = 1;
        $fare = $this->fare($parcel);
        $office = $parcel->transported_route ?: ($parcel->destination ?? '');

        return trim("TILISHO PARCEL
Habari {$parcel->receiver_name}, mzigo wako {$parcel->tracking_number} kutoka kwa {$parcel->sender_name} upo ofisini {$office}
Cargo: {$cargo} ({$qty})
Fare: {$fare}
Ship Date: {$shipDate}
Fika ofisini na ujumbe huu kuuchukua.
Msaada: 0750015630
Web: www.tilishosafari.co.tz");
    }

    private function shipDate(Parcel $parcel): string
    {
        if (! $parcel->travel_date) {
            return Carbon::now()->format('d-m-Y');
        }

        return Carbon::parse($parcel->travel_date)->format('d-m-Y');
    }

    private function cargo(Parcel $parcel): string
    {
        $d = trim((string) ($parcel->description ?? ''));

        return $d !== '' ? $d : 'mzigo';
    }

    private function fare(Parcel $parcel): string
    {
        $amount = is_numeric($parcel->amount) ? (float) $parcel->amount : 0.0;
        $formatted = number_format($amount, 0, '.', ',');

        return "TZS {$formatted}";
    }
}

