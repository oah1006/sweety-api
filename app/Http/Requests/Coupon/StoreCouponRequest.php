<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:coupons,name'],
            'description' => ['required', 'string', 'min:2', 'max:255'],
            'stock' => ['required', 'integer'],
            'is_percent_value' => ['required', 'numeric', 'between:0,100'],
            'min_order_total' => ['required', 'numeric'],
            'status' => ['required', 'in:active,expired,deactivate'],
            'started_at' => ['required', 'date'],
            'expired_at' => ['required', 'date'],
        ];
    }
}
