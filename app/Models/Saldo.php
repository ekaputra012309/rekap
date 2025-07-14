<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Saldo extends Model
{
    use HasFactory;

    protected $fillable = [
        'saldo_awal',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
