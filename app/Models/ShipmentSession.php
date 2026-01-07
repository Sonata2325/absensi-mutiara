<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShipmentSession extends Model
{
    protected $fillable = [
        'truck_id',
        'driver_id',
        'order_ids',
        'status',
        'waktu_berangkat',
        'waktu_selesai',
        'admin_berangkatkan_nama',
        'admin_selesaikan_nama',
        'catatan',
    ];

    protected $casts = [
        'order_ids' => 'array',
        'waktu_berangkat' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
