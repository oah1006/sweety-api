<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'min:2', 'max:255', Rule::unique('coupons')->ignore($this->coupon)],
            'description' => ['nullable', 'string', 'min:2', 'max:255'],
            'stock' => ['nullable', 'integer'],
            'is_percent_value' => ['nullable', 'numeric', 'between:0,100'],
            'min_order_total' => ['nullable', 'numeric'],
            'status' => ['nullable', 'in:active,expired,deactivate'],
            'started_at' => ['nullable', 'date'],
            'expired_at' => ['nullable', 'date'],
            'points' => ['nullable', 'integer'],
        ];
    }
}
