<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsBrand extends Model
{
    use HasFactory;

    protected $table = 'products_brand';

    protected $fillable = [
        'brand_id',
        'product_id',
    ];
}
