<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = ['order_id', 'product_id', 'batch_id', 'storage_id', 'quantity', 'price_at_sale'];
    protected $hidden = ['order_id', 'product_id', 'batch_id', 'storage_id', 'created_at', 'updated_at'];
}