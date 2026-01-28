<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    protected $fillable = [
        'nama_shift',
        'jam_masuk',
        'jam_keluar',
        'toleransi_terlambat',
        'deskripsi',
        'is_active',
        'is_flexible',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_flexible' => 'boolean',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'shift_id');
    }
}
