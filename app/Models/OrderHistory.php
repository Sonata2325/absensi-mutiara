<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderHistory extends Model
{
    protected $table = 'order_history';

    protected $fillable = [
        'order_id',
        'status_sebelumnya',
        'status_baru',
        'keterangan',
        'admin_nama',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
