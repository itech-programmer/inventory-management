<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Batch extends Model
{
    protected $fillable = ['provider_id', 'purchase_date'];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}