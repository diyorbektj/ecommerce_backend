<?php

namespace App\Services;

use App\DTO\AddressDTO;
use App\DTO\CreateProductOrderDTO;
use App\DTO\OrderDTO;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Address;
use App\Models\Basket;
use App\Models\Order;
use App\Models\ProductOrders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public static function createOrder(CreateOrderRequest $request)
    {
        DB::beginTransaction();

        try {
            $order = Order::query()->create(OrderDTO::toArray($request->validated()));
            Address::query()->create(AddressDTO::toArray($request->validated(), $order->id));
            $products = [];
            foreach ($request->products as $product) {
                $products[] = CreateProductOrderDTO::toArray($product, $order->id);
            }
            $product_order = ProductOrders::query()->insert($products);
            Basket::query()->where('guid', $request->input('guid'))->delete();
            DB::commit();
            return $product_order;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
