<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JenisMotor extends Model
{
    protected $fillable = ['tipe', 'merk'];

    public function spareparttipemotor(){
        return $this->hasMany('App\Model\SparepartTipeMotor', 'fk_jenis_motor', 'id');
    }
    public function kendaraan()
    {
        return $this->hasOne('App\Model\Kendaraan', 'fk_jenis', 'id');
    }
}
