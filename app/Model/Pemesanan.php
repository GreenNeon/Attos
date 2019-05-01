<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $fillable = ['fk_supplier', 'tanggal', 'total', 'status'];
}
