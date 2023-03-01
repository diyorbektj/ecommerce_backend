<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\ProductOrdersResource;
use App\Models\Address;
use App\Models\Basket;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderRepository $orderRepository;

    private OrderService $orderService;

    public function __construct(OrderRepository $orderRepositorie, OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepositorie;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->orderRepository->allOrders();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderRequest  $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        return response()->json($this->orderService->createOrder($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        return response()->json([
            'data' => ProductOrdersResource::collection($this->orderRepository->getOrder($id)),
            'address' => Address::query()->where('order_id', $id)->first() ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $this->orderRepository->updateOrder($id, $request->all());

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->orderRepository->deleteOrder($id);

        return response()->json(['message' => 'Order deleted'], 200);
    }

    public function buyproduct(Request $request, $hash)
    {
        $product = Product::query()->where('id_hash', $hash)->first();

        if ($hash == md5('basket')) {
            $amount = 0;
            $baskets = Basket::query()->where('guid', $request->guid)->get();
            foreach ($baskets as $basket) {
                $amounts = $basket->price * $basket->quantity;
                $amount += $amounts;
            }

            return response()->json(['data' => $baskets, 'amount' => $amount]);
        } elseif ($product) {
            return response()->json([
                'data' => [
                    ['product_id' => $product->id,
                        'user_id' => auth('sanctum')->id() ?? null,
                        'guid' => $request->guid,
                        'product_name' => $product->name,
                        'product_image' => $product->image->path,
                        'quantity' => $request->quantity,
                        'price' => $product->price, ],
                ],
                'amount' => $product->price,
            ]);
        }

        return response()->json(['message' => 'Not found']);
    }

    public function myorders(): JsonResponse
    {
        $orders = Order::query()->where('user_id', auth('sanctum')->id())->get();

        return response()->json($orders);
    }
}
