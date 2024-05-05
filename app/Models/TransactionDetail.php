<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'tk_4.tb_detail_transaction';
    protected $primaryKey = 'id_detail_transaction';
    public $timestamps = false;
}
