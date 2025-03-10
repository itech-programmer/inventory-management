<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface StorageRepositoryInterface
{
    public function getRemainingQuantities(string $date): Collection;
}