<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gib extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'nama_donatur',
        'nominal',
        'bayar_id',
        'user_id',
    ];

    public function bayar()
    {
        return $this->belongsTo(Bayar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
