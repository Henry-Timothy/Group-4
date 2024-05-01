<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'tb_pengguna';
    protected $primaryKey = 'IdPengguna';
    public $timestamps = false;
}
