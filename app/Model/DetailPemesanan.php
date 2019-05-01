<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    protected $fillable = ['fk_pemesanan', 'fk_sparepart', 'nama', 'jumlah', 'total'];
    
    public function sparepart(){
        return $this->belongsTo('App\Model\Sparepart', 'fk_sparepart', 'id');
    }
}
