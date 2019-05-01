<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetailServis extends Model
{
    protected $fillable = ['fk_jasa_servis','fk_transaksi','fk_kendaraan','fk_montir', 'jumlah', 'total', 'status'];

    public function jasaservis()
    {
        return $this->belongsTo('App\Model\JasaServis', 'fk_jasa_servis', 'id');
    }
    public function transaksi()
    {
        return $this->belongsTo('App\Model\Transaksi', 'fk_transaksi', 'id');
    }
    public function fk_kendaraan()
    {
        return $this->belongsTo('App\Model\Kendaraan', 'fk_kendaraan', 'id');
    }
    public function montirkerja()
    {
        return $this->belongsTo('App\Model\MontirKerja', 'fk_montir', 'id');
    }
}
