<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\ProductOrders;

class OrderRepository implements \App\Interfaces\OrderInterface
{
    public function createOrder(array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return Order::query()->create($data);
    }

    public function allOrders()
    {
        return Order::query()->orderByDesc('created_at')->with('status')->get();
    }

    public function getOrder(int $id)
    {
        return ProductOrders::query()->where('order_id', $id)->get();
    }

    public function updateOrder(int $id, array $data)
    {
        // TODO: Implement updateOrder() method.
    }

    public function deleteOrder(int $id)
    {
        // TODO: Implement deleteOrder() method.
    }
}
