<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    protected $table = 'punya_farrel.tb_selling';
    protected $primaryKey = 'id_selling';
    public $timestamps = false;
}
