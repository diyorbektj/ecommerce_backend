<?php

namespace App\Http\Middleware;

use App\Models\Guest;
use App\Services\CreateGUIDService;
use Closure;
use Illuminate\Http\Request;

class CheckGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//        if(!$request->has('guid')){
//            Guest::query()->create([
//                'guid' => CreateGUIDService::generate()
//            ]);
//        }
        return $next($request);
    }
}
