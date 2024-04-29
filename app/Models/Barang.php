<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'introduction_to_data.tb_barang';
    protected $primaryKey = 'IdBarang';
    public $timestamps = false;
}
