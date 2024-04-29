<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'introduction_to_data.tb_pembelian';
    protected $primaryKey = 'IdPembelian';
    public $timestamps = false;
}
