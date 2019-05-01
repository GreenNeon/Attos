<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SparepartTipeMotor extends Model
{
    protected $fillable = ['fk_sparepart','fk_jenis_motor'];

    public function sparepart(){
        return $this->belongsTo('App\Model\Sparepart', 'fk_sparepart','id');
    }

    public function jenismotor(){
        return $this->belongsTo('App\Model\JenisMotor', 'fk_jenis_motor','id');
    }
}
