<?php

namespace App\Http\Requests\Order;

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
            'code' => ['required'],
            'coupon_id' => ['required', 'exists:coupons,id'],
            'delivery_address_id' => ['required', 'exists:delivery_addresses,id'],
            'total' => ['required', 'numeric'],
            'sub_total' => ['required', 'numeric'],
            'status' => ['required', 'in:pending,succeed,delivering,canceled,failed'],
            'products' => [ 'required', 'array'],
            'product.*' => ['array:product_id,quantity']
        ];
    }
}
