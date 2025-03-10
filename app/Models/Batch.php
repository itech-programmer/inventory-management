<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    protected $fillable = ['provider_id', 'purchase_date', 'purchase_cost'];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'batch_products')
            ->withPivot('quantity', 'price_at_purchase')
            ->withTimestamps();
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class, 'batch_id');
    }

}