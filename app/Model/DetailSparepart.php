<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetailSparepart extends Model
{
    protected $fillable = ['fk_transaksi','fk_sparepart', 'fk_montir','jumlah','total'];

    public function transaksi()
    {
        return $this->belongsTo('App\Model\Transaksi', 'fk_transaksi', 'id');
    }
    public function sparepart()
    {
        return $this->belongsTo('App\Model\Sparepart', 'fk_sparepart', 'id');
    }
    public function montirkerja()
    {
        return $this->belongsTo('App\Model\MontirKerja', 'fk_montir', 'id');
    }
}
