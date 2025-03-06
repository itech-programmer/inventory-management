<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = ['name', 'category_id', 'price'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}