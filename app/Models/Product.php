<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['name', 'category_id', 'price'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'batch_products')
            ->withPivot('quantity', 'price_at_purchase')
            ->withTimestamps();
    }

    public function storages(): BelongsToMany
    {
        return $this->belongsToMany(Storage::class, 'storage_products')
            ->withPivot('quantity', 'price_at_purchase')
            ->withTimestamps();
    }
}