<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuidController extends Controller
{
    public function generate(Request $request)
    {
        if ($guid = \App\Models\Guest::query()->where('guid', $request->guid ?? null)->first()) {
            $guid = $guid->guid;
        } else {
            $guid = \App\Services\CreateGUIDService::generate();
            \App\Models\Guest::query()->create([
                'guid' => $guid,
            ]);
        }

        return response()->json(['guid' => $guid]);
    }
}
