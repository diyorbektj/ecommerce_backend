<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brands;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = Brands::all();

        return response()->json(BrandResource::collection($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateBrandRequest $request): \Illuminate\Http\JsonResponse
    {
        $file = $request->file('image');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads', $fileName, 'public');

        $brands = Brands::query()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => "/storage/".$path
        ]);

        return response()->json(new BrandResource($brands), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        return response()->json(new BrandResource(Brands::query()->find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $data = Brands::query()->find($id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        Brands::query()->find($id)->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }
}
