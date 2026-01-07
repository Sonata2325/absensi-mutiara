<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Truck extends Model
{
    protected $fillable = [
        'plat_nomor',
        'jenis_armada',
        'kapasitas_kg',
        'status',
        'driver_id_current',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function shipmentSessions(): HasMany
    {
        return $this->hasMany(ShipmentSession::class);
    }
}
