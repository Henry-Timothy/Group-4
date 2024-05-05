<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tk_4.tb_customer';
    protected $primaryKey = 'id_customer';
    public $timestamps = false;
}
