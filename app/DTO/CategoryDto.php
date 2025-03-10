<?php

namespace App\DTO;

class CategoryDto
{
    public string $name;
    public ?int $parent_id;
    public ?int $provider_id;

    public function __construct(string $name, ?int $parent_id = null, ?int $provider_id = null)
    {
        $this->name = $name;
        $this->parent_id = $parent_id;
        $this->provider_id = $provider_id;
    }
}
