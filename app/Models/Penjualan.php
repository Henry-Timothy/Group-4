<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'introduction_to_data.tb_penjualan';
    protected $primaryKey = 'IdPenjualan';
    public $timestamps = false;
}