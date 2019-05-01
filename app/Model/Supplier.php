<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['nama', 'alamat', 'telepon'];

    public function sales(){
        return $this->hasMany('App\Model\Sales', 'fk_supplier', 'id');
    }
}
