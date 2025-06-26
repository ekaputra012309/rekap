<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemasukan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'rincian_pemasukan',
        'nominal',
        'keterangan',
        'income_id',
        'user_id',
    ];

    public function income()
    {
        return $this->belongsTo(Income::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
