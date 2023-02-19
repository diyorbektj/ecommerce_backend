<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class ProductColorFilter
{
    public function handle($request, \Closure $next)
    {
        if (! request()->has('color')) {
            return $next($request);
        }

        return $next($request)->whereHas('getProductAttribute', function (Builder $query) {
            $query->whereIn('value', \request()->input('color'));
        });
    }
}
