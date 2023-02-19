<?php

namespace App\Http\Requests;

use App\Models\Brands;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|min:3|max:255',
            'description' => 'string|min:3',
            'images' => '',
            'quantity' => 'numeric',
            'price' => '',
            'category_id' => [Rule::exists(Category::class, 'id')],
            'subcategory_id' => [Rule::exists(SubCategory::class, 'id')],
            'brand_id' => [Rule::exists(Brands::class, 'id')],
            'attribute' => 'json',
        ];
    }
}
