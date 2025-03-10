<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends Model
{
    protected $fillable = ['batch_id', 'order_id', 'quantity', 'refund_amount'];
    protected $hidden = ['created_at', 'updated_at'];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}