<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = [
        'nama_posisi',
        'kode_posisi',
        'deskripsi',
        'manager_id',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'position_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
