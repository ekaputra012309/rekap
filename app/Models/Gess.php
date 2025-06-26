<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gess extends Model
{
    use HasFactory;
    protected $table = 'gesss';

    protected $fillable = [
        'tanggal',
        'nama_donatur',
        'kaleng',
        'nominal',
        'keterangan',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
