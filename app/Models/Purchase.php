<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'tk_4.tb_purchase';
    protected $primaryKey = 'id_purchase';
    public $timestamps = false;
}
