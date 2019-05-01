<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = ['fk_supplier','nama','telepon'];
    
    public function supplier(){
        return $this->belongsTo('App\Model\Supplier', 'fk_supplier');
    }
}
