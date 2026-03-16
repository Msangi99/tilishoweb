<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'plate_number',
        'model',
        'capacity',
        'status',
        'route_id',
        'drivers',
        'conductors',
        'attendants',
    ];

    protected $casts = [
        'drivers' => 'array',
        'conductors' => 'array',
        'attendants' => 'array',
    ];

    public function route()
    {
        return $this->belongsTo(BusRoute::class, 'route_id');
    }
}
