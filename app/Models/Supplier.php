<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'punya_farrel.tb_supplier';
    protected $primaryKey = 'id_supplier';
    public $timestamps = false;
}
