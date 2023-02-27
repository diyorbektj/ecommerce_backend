<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\ProductSize;

class ProductAttributeController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'colors' => Color::all()->pluck('color_name'),
            'sizes' => ProductSize::query()->orderByDesc('sort')->get()->pluck('size'),
        ]);
    }
}
