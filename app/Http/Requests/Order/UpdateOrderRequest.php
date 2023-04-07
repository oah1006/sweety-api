<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'coupon_id' => ['nullable', Rule::unique('coupons')->ignore($this->coupon)],
            'delivery_address_id' => ['nullable', Rule::unique('delivery_addresses')->ignore($this->delivery_address)],
            'total' => ['nullable', 'numeric'],
            'sub_total' => ['nullable', 'numeric'],
            'status' => ['nullable', 'in:pending,succeed,delivering,canceled,failed']
        ];
    }
}
