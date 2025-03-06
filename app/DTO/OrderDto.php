<?php

namespace App\DTO;

class OrderDto
{
    public int $client_id;
    public array $products;

    public function __construct(int $client_id, array $products)
    {
        $this->client_id = $client_id;
        $this->products = $products;
    }
}