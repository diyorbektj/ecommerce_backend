<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

//    protected $fillable = [
//        'name',
//        'description',
//        'category_id',
//        'is_active',
//        'price',
//        'quantity',
//    ];

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductImages::class, 'product_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    //get Product Attribute
    public function getProductAttribute()
    {
        return $this->hasMany(ProductAttributes::class, 'product_id', 'id')->with('attribute');
    }
}
