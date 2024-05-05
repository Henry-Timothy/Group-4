<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'tk_4.tb_transaction';
    protected $primaryKey = 'id_transaction';
    public $timestamps = false;
}
