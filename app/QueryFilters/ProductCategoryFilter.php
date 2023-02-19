<?php

namespace App\QueryFilters;

class ProductCategoryFilter
{
    public function handle($request, \Closure $next)
    {
        if (! request()->has('category_id') or request()->input('category_id') === 'all') {
            return $next($request);
        }

        return $next($request)->where('category_id', request()->input('category_id'));
    }
}
