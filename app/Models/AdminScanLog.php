<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminScanLog extends Model
{
    protected $fillable = [
        'order_id',
        'truck_id',
        'shipment_session_id',
        'admin_nama',
        'action',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function shipmentSession(): BelongsTo
    {
        return $this->belongsTo(ShipmentSession::class);
    }
}
