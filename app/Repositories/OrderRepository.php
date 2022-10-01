<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    /**
     * @param array $orderData
     *
     * @return Order|null
     */
    public function createOrder(array $orderData): ?Order
    {
        return Order::create($orderData);
    }
}
