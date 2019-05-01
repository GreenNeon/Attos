<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HistoriKeluar extends Model
{
    protected $fillable = ['fk_detail_sparepart', 'fk_sparepart', 'tanggal', 'jumlah', 'total'];

    public function sparepart()
    {
        return $this->belongsTo('App\Model\Sparepart', 'fk_sparepart', 'id');
    }
}
