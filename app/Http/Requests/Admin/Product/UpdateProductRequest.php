<?php

namespace App\Http\Requests\Admin\Product;

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
            'name' => ['nullable', 'string', Rule::unique('products')->ignore($this->product)],
            'description' => ['bail', 'nullable', 'string'],
            'price' => ['bail', 'nullable', 'numeric'],
            'category_id' => ['bail', 'nullable', 'exists:categories,id'],
            'published' => ['bail', 'nullable', 'boolean'],
            'toppings' => ['bail', 'nullable', 'array'],
            'topping.*' => ['array:product_id,topping_id'],
            'variants' => ['nullable', 'array'],
            'variant.*' => ['array:size,unit_price']
        ];
    }
}
