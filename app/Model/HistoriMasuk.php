<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HistoriMasuk extends Model
{
    protected $fillable = ['fk_pemesanan', 'fk_sparepart', 'tanggal', 'jumlah', 'harga'];

    public function sparepart()
    {
        return $this->belongsTo('App\Model\Sparepart', 'fk_sparepart', 'id');
    }
}
