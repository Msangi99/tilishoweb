<?php

namespace App\Observers;

use App\Models\Parcel;
use App\Models\Wallet;

class ParcelWalletObserver
{
    public function created(Parcel $parcel): void
    {
        Wallet::adjustForParcelAmount((float) $parcel->amount, 1);
    }

    public function deleted(Parcel $parcel): void
    {
        Wallet::adjustForParcelAmount((float) $parcel->amount, -1);
    }
}
