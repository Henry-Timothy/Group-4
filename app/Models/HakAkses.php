<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    protected $table = 'introduction_to_data.tb_hak_akses';
    protected $primaryKey = 'IdAkses';
    public $timestamps = false;
}
