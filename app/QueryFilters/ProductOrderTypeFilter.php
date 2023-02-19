<?php

namespace App\QueryFilters;

class ProductOrderTypeFilter
{
    public function handle($request, \Closure $next)
    {
        $query = $next($request);
        if (request()->input('order_type') == 'new') {
            return $query->orderByDesc('created_at');
        }
        if (request()->input('order_type') == 'old') {
            return $query->orderBy('created_at');
        }

        return $query;
    }
}
