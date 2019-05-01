<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PegawaiKerja extends Model
{
    protected $fillable = ['fk_pegawai','fk_transaksi'];

    public function pegawai()
    {
        return $this->belongsTo('App\Model\Pegawai', 'fk_pegawai', 'id');
    }
    public function transaksi()
    {
        return $this->belongsTo('App\Model\Transaksi', 'fk_transaksi', 'id');
    }
}
