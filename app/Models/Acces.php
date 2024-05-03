<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acces extends Model
{
    protected $table = 'punya_farrel.tb_acces';
    protected $primaryKey = 'id_acces';
    public $timestamps = false;
}
