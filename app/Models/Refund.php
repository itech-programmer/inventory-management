<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = ['batch_id', 'order_id', 'quantity', 'refund_amount'];
}