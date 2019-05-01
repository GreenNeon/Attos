<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['kode','fk_telepon','fk_cabang','tanggal','subtotal','diskon','total'];
    public function detailservis()
    {
        return $this->hasMany('App\Model\DetailServis', 'fk_transaksi', 'id');
    }
    public function detailsparepart()
    {
        return $this->hasMany('App\Model\DetailSparepart', 'fk_transaksi', 'id');
    }
    public function pegawaikerja()
    {
        return $this->hasMany('App\Model\PegawaiKerja', 'fk_transaksi', 'id');
    }
}
