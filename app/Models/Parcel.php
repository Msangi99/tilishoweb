<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $fillable = [
        'tracking_number',
        'sender_name',
        'sender_phone',
        'receiver_name',
        'receiver_phone',
        'origin',
        'destination',
        'amount',
        'description',
        'status',
        'created_by',
        'scanned_by',
        'bus_id',
        'travel_date',
        'start_travel_time',
        'end_travel_time',
        'transported_by_id',
        'transported_by_name',
        'transported_bus_id',
        'transported_route',
        'transported_at',
        'received_by_id',
        'received_by_name',
        'received_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($parcel) {
            $parcel->tracking_number = self::generateUniqueTrackingNumber();
            $parcel->created_by = auth()->id() ?? 1; // Default to admin if not auth (for testing)
        });
    }

    public static function generateUniqueTrackingNumber()
    {
        do {
            $number = rand(100, 999);
            $chars = strtoupper(\Illuminate\Support\Str::random(3));
            $trackingNumber = "TLS{$number}{$chars}";
        } while (self::where('tracking_number', $trackingNumber)->exists());

        return $trackingNumber; 
    }

    public function scannedBy()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    public function transportedBy()
    {
        return $this->belongsTo(User::class, 'transported_by_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by_id');
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function getDisplayStatusAttribute()
    {
        if (!$this->travel_date || !$this->start_travel_time || !$this->end_travel_time) {
            return $this->status;
        }

        $now = \Carbon\Carbon::now();
        $start = \Carbon\Carbon::parse($this->travel_date . ' ' . $this->start_travel_time);
        $end = \Carbon\Carbon::parse($this->travel_date . ' ' . $this->end_travel_time);

        if ($now->lt($start)) {
            return 'packed';
        } elseif ($now->lt($end)) {
            return 'in-transit';
        } else {
            return 'arrived';
        }
    }
}
