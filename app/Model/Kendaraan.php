<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;


class Kendaraan extends Model
{
    protected $fillable = ['no_plat','fk_jenis','fk_telepon'];
    public function jenismotor()
    {
        return $this->belongsTo('App\Model\JenisMotor', 'fk_jenis', 'id');
    }
    public function konsumen()
    {
        return $this->belongsTo('App\Model\Konsumen', 'fk_telepon', 'telepon');
    }
}
