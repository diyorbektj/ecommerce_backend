<?php

namespace App\Http\Controllers;

use App\Http\Resources\BasketResource;
use App\Models\Basket;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $basket = Basket::query()
            ->where('guid', $request->guid)
            ->where('product_id', $request->id)
            ->where('id_hash', $request->hash)
            ->first();
        if ($basket) {
            $basket->update(['quantity' => DB::raw("quantity + $request->quantity")]);
        } else {
            $product = Product::with('image')->find($request->id);
            $basket = Basket::query()->create([
                'product_id' => $product->id,
                'user_id' => auth('sanctum')->id() ?? null,
                'product_name' => $product->name,
                'product_image' => $product->image->path,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'guid' => $request->guid,
                'id_hash' => $request->hash,
                'attributes' => json_encode([$request->color, $request->size ?? '']),
            ]);
        }

        return response()->json(new BasketResource($basket));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Basket $basket)
    {
        return response()->json(BasketResource::collection($basket->where('guid', \request()->guid)->get()));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function edit(Basket $basket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Basket $basket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Basket  $basket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = Basket::query()->findOrFail($request->id)->delete();

        return $data;
    }

    public function decrement(Request $request)
    {
        $basket = Basket::query()->where('id_hash', $request->hash)->first();
        if ($basket->quantity == 1) {
            $basket->delete();
        } else {
            $basket->update(['quantity' => DB::raw('quantity - 1')]);
        }

        return response()->json(BasketResource::collection(Basket::all()));
    }

    public function increment(Request $request)
    {
        $basket = Basket::query()->where('id_hash', $request->hash);
        $basket->update(['quantity' => DB::raw('quantity + 1')]);

        return response()->json(new BasketResource($basket->first()));
    }

    public function clear_basket(Request $request)
    {
        $basket = Basket::query()->where('guid', $request->input('guid'))->delete();

        return response()->json(['message' => 'Deleted!!']);
    }
}
