<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    // Untuk Cabang
    protected $fillable = ['nama', 'alamat', 'telepon'];

    public function pegawai(){
        return $this->hasMany('App\Model\Pegawai', 'fk_cabang','id');
    }
}
