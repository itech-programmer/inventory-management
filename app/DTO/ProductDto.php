<?php

namespace App\DTO;

class ProductDto
{
    public string $name;
    public int $category_id;
    public float $price;

    public function __construct(string $name, int $category_id, float $price)
    {
        $this->name = $name;
        $this->category_id = $category_id;
        $this->price = $price;
    }
}