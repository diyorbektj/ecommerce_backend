<?php

namespace App\Http\Controllers;

use App\DTO\AddressDTO;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  AddressRequest  $request
     * @return JsonResponse
     */
    public function store(AddressRequest $request)
    {
        $dto = AddressDTO::toArray($request->validated());
        $address = Address::query()->create($dto);

        return response()->json($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return AddressResource
     */
    public function show()
    {
        $address = Address::query()->where('user_id', auth('sanctum')->id())->first();

        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return AddressResource
     */
    public function update(AddressRequest $request)
    {
        $dto = AddressDTO::toArray($request->validated());
        $address = Address::query()->where('user_id', auth('sanctum')->id())->update($dto);

        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy()
    {
        Address::query()->where('user_id', auth('sanctum')->id())->delete();

        return response()->json(['message' => 'ok!']);
    }
}
