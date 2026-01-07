<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'nomor_resi',
        'jenis_layanan',
        'pengirim_nama',
        'pengirim_kontak_person',
        'pengirim_telepon',
        'pengirim_email',
        'pengirim_alamat_pickup',
        'pengirim_jadwal_pickup',
        'pengirim_catatan_pickup',
        'pengirim_office_id',
        'penerima_nama',
        'penerima_telepon',
        'penerima_alamat',
        'penerima_catatan',
        'deskripsi_barang',
        'berat_kg',
        'panjang_cm',
        'lebar_cm',
        'tinggi_cm',
        'jenis_armada_diminta',
        'fragile',
        'catatan_barang',
        'status',
        'truck_id',
        'driver_id',
        'shipment_session_id',
        'qr_code_data',
        'qr_checksum',
        'tanggal_order',
    ];

    protected $casts = [
        'pengirim_jadwal_pickup' => 'datetime',
        'berat_kg' => 'decimal:2',
        'fragile' => 'boolean',
        'qr_code_data' => 'array',
        'tanggal_order' => 'datetime',
    ];

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function shipmentSession(): BelongsTo
    {
        return $this->belongsTo(ShipmentSession::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(OrderHistory::class)->latest();
    }
}
