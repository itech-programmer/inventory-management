<?php

namespace App\DTO;

class RefundDto
{
    public ?int $batch_id;
    public ?int $order_id;
    public int $quantity;
    public float $refund_amount;

    public function __construct(?int $batch_id, ?int $order_id, int $quantity, float $refund_amount)
    {
        $this->batch_id = $batch_id;
        $this->order_id = $order_id;
        $this->quantity = $quantity;
        $this->refund_amount = $refund_amount;
    }
}