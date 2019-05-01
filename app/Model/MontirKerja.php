<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MontirKerja extends Model
{
    protected $fillable = ['fk_pegawai','fk_kendaraan'];

    public function pegawai()
    {
        return $this->belongsTo('App\Model\Pegawai', 'fk_pegawai', 'id');
    }

    public function kendaraan()
    {
        return $this->belongsTo('App\Model\Kendaraan', 'fk_kendaraan', 'id');
    }
}
