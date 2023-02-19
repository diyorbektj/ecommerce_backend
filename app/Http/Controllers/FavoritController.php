<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoritesResource;
use App\Models\Favorit;
use App\Repositories\FavoriteRepository;
use Illuminate\Http\Request;

class FavoritController extends Controller
{
    protected FavoriteRepository $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $favorite = Favorit::query()
            ->where('guid', $request->guid)
            ->where('product_id', $request->product_id)
            ->first();
        if (! $favorite) {
            $favorite = Favorit::query()->create([
                'guid' => $request->guid ?? 'test',
                'user_id' => auth('sanctum')->id() ?? null,
                'product_id' => $request->product_id,
            ]);
        }

        return response()->json($favorite);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favorit  $favorit
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show()
    {
        $favorites = $this->favoriteRepository->show();

        return response()->json(FavoritesResource::collection($favorites));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Favorit  $favorit
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorit $favorit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorit  $favorit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorit $favorit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorit  $favorit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Favorit $favorit)
    {
        $favorit->query()->where('guid', \request()->guid)->delete();

        return response()->json('Deleted!!!');
    }
}
