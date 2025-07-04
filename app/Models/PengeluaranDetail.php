<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranDetail extends Model
{
    use HasFactory;

    protected $fillable = ['pengeluaran_header_id', 'outcome_id', 'custom_rincian', 'keterangan', 'nominal'];

    public function header()
    {
        return $this->belongsTo(PengeluaranHeader::class, 'pengeluaran_header_id');
    }

    public function outcome()
    {
        return $this->belongsTo(Outcomes::class, 'outcome_id');
    }

    public function getRincianAttribute()
    {
        return $this->outcome_id ? $this->outcome->name : $this->custom_rincian;
    }
}
