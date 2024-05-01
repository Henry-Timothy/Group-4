<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    protected $table = 'tb_hak_akses';
    protected $primaryKey = 'IdAkses';
    public $timestamps = false;
}
