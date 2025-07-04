<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemasukanDetail extends Model
{
    use HasFactory;

    protected $fillable = ['pemasukan_header_id', 'income_id', 'custom_rincian', 'keterangan', 'nominal'];

    public function header()
    {
        return $this->belongsTo(PemasukanHeader::class, 'pemasukan_header_id');
    }

    public function income()
    {
        return $this->belongsTo(Incomes::class, 'income_id');
    }

    public function getRincianAttribute()
    {
        return $this->income_id ? $this->income->name : $this->custom_rincian;
    }
}
