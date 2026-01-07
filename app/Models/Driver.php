<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    protected $fillable = [
        'nama',
        'telepon',
        'email',
        'nomor_sim',
        'status',
        'truck_id_current',
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
