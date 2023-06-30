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
            'name' => ['bail', 'required', 'string', 'unique:products,name'],
            'description' => ['bail', 'required', 'string'],
            'stock' => ['bail', 'required', 'integer'],
            'price' => ['bail', 'required', 'numeric'],
            'category_id' => ['bail', 'required', 'exists:categories,id'],
            'published' => ['bail', 'required', 'boolean'],
            'thumbnail' => ['bail', 'nullable', 'file', 'mimes:jpg,jpeg,png'],
            'detail_products' => ['bail', 'nullable', 'array'],
            'detail_products.*' => ['bail', 'file', 'mimes:jpg,jpeg,png'],
            'toppings' => ['nullable', 'array'],
            'topping.*' => ['array:product_id,topping_id']
        ];
    }
}
