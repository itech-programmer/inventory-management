<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Storage extends Model
{
    protected $fillable = ['location'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'storage_products')
            ->withPivot('quantity', 'price_at_purchase')
            ->withTimestamps();
    }
}