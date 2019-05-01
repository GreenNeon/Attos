<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $fillable = ['nama','tipe','kode_penempatan','stok','stok_optimal','harga','gambar_url'];

    public function spareparttipemotor(){
        return $this->hasMany('App\Model\SparepartTipeMotor', 'fk_sparepart', 'id');
    }
    public function detailpemesanan(){
        return $this->hasMany('App\Model\DetailPemesanan', 'fk_sparepart', 'id');
    }
}
