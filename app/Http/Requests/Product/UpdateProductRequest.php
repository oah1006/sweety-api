<?php

namespace App\Http\Requests\Product;

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
            'name' => ['nullable', 'string', Rule::unique('categories')->ignore($this->category)],
            'description' => ['nullable', 'string'],
            'stock' => ['nullable', 'integer'],
            'price' => ['nullable', 'numeric'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'published' => ['nullable', 'boolean'],
        ];
    }
}
