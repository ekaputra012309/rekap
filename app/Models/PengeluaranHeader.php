<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranHeader extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'total', 'user_id'];
    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(PengeluaranDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional: Automatically calculate total
    public function calculateTotal()
    {
        $total = $this->details()->sum('nominal');
        $this->update(['total' => $total]);
    }
}
