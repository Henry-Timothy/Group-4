<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'tk_4.tb_item';
    protected $primaryKey = 'id_item';
    public $timestamps = false;
}
