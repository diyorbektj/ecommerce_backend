<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function createOrder(array $data);

    public function allOrders();

    public function getOrder(int $id);

    public function updateOrder(int $id, array $data);

    public function deleteOrder(int $id);
}
