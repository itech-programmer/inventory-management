<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Order extends Model
{
    protected $fillable = ['client_id'];
    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, OrderProduct::class)
            ->withPivot('quantity', 'price_at_sale')
            ->withTimestamps();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}