<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Color;
use App\Models\ProductAttributes;
use App\Models\ProductOrders;
use App\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public static function createProductOrders($order, $product)
    {
        $productOrder = ProductOrders::query()->where('order_id', $order->id)->where('product_id', $product->id)->first();
        if ($productOrder) {
            $productOrder->increment('quantity');
        } else {
            $productOrder = ProductOrders::query()->create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return $productOrder;
    }

    public function createProduct(CreateProductRequest $request): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $data = ProductDTO::toArray($request->validated());
        $product = $this->productRepository->createProduct($data);
        if ($request->hasFile('images')) {
            $images = (new ProductDTO())->uploadImage($request->file('images'), $product->id);
            $product->images()->insert($images);
        }
        $productAttributes = ProductAttributes::query()->where('product_id', $product->id);
        foreach (json_decode($request->attribute) as $attribute) {
            $attribute1 = [];
            foreach ($attribute?->values as $value) {
                $color = Color::query()->where('color_name', $value)->first();
                $attribute1[] = [
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->attribute_id,
                    'value' => $value,
                    'color' => $color->color_code ?? '#e7e7e7',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $productAttributes->where('attribute_id', $attribute->attribute_id)->insert($attribute1);
        }
        //TelegramService::sendMessage(['chat_id' => -1001581996353, 'text' => "Новый продукт \nПродукт: ".$product->name."\nЦена: ".$product->price."\nКоличество: ".$product->quantity."\nСтатус: active\nДата: ".$product->created_at]);
        return $product;
    }

    public function updateProduct(UpdateProductRequest $request, $id)
    {
//        DB::beginTransaction();
//            try {
        $data = ProductDTO::toArray($request->validated());
        $product = $this->productRepository->updateProduct($id, $data);
        if ($request->hasFile('images')) {
            $images = (new ProductDTO())->uploadImage($request->file('images'), $product->id);
            $product->images()->insert($images);
        }
//        foreach (json_decode($request->attribute) as $attribute) {
//            ProductAttributes::query()->updateOrCreate([
//                'product_id' => $id,
//                'attribute_id' => $attribute->attribute_id,
//                'value' => $attribute->value,
//            ]);
//        }

        return $product;
//        } catch (\Exception $ex) {
//            DB::rollback();
//            return response()->json(['error' => $ex->getMessage()], 500);
//        }
    }
}
