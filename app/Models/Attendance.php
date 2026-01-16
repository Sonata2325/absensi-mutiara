<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'lokasi_masuk_lat',
        'lokasi_masuk_lng',
        'lokasi_keluar_lat',
        'lokasi_keluar_lng',
        'foto_masuk',
        'foto_keluar',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
