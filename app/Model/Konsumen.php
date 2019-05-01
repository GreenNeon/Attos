<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    protected $fillable = ['telepon','nama','alamat'];
    protected $primaryKey = 'telepon';
    protected $keyType = 'string';
    public $incrementing = false;

    public function kendaraan()
    {
        return $this->hasOne('App\Model\Kendaraan', 'fk_telepon', 'telepon');
    }
}
