<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_dokter',
        'poli_id',
        'keterangan',
        'user_id',
    ];

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poliklinik::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
