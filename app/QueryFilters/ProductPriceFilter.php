<?php

namespace App\QueryFilters;

class ProductPriceFilter
{
    public function handle($request, \Closure $next)
    {
        $query = $next($request);
        if (request()->has('price_min')) {
            $query->where('price', '>=', request()->input('price_min'));
        }
        if (request()->has('price_max')) {
            $query->where('price', '<=', request()->input('price_max'));
        }

        return $query;
    }
}
