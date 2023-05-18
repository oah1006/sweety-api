<?php

namespace App\Http\Requests\Admin\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'code' => ['nullable'],
            'coupon_id' => ['nullable', 'exists:coupons,id'],
            'address_id' => ['nullable', 'exists:addresses,id'],
            'total' => ['nullable', 'numeric'],
            'sub_total' => ['nullable', 'numeric'],
            'status' => ['nullable', 'in:pending,succeed,delivering,canceled,failed'],
            'products' => ['nullable', 'array'],
            'product.*' => ['array:product_id,quantity'],
            'product.*.id' => ['required', 'exists:order_items,id']
        ];
    }
}
