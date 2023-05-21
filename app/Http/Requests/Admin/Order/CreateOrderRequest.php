<?php

namespace App\Http\Requests\Admin\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'coupon_id' => ['required', 'exists:coupons,id'],
            'address_id' => ['required', 'exists:addresses,id'],
            'total' => ['required', 'numeric'],
            'sale_staff_id' => ['nullable', 'exists:staff,id'],
            'delivery_staff_id' => ['nullable', 'exists:staff,id'],
            'sub_total' => ['required', 'numeric'],
            'status' => ['required', 'in:pending,canceled,accepted,preparing,prepared,delivering,succeed,failed'],
            'products' => [ 'required', 'array'],
            'product.*' => ['array:product_id,qty']
        ];
    }
}
