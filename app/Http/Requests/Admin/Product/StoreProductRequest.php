<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:products,name'],
            'description' => ['required', 'string'],
            'stock' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'exists:categories,id'],
            'published' => ['required', 'boolean'],
            'thumbnail' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
            'detail_products' => ['nullable', 'array'],
            'detail_products.*' => ['file', 'mimes:jpg,jpeg,png'],
            'toppings' => ['nullable', 'array'],
            'topping.*' => ['array:product_id,topping_id']
        ];
    }
}