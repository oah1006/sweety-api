<?php

namespace App\Http\Requests\Admin\Customer;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
            'email' => ['required', 'email:rfc,dns', 'string', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'full_name' => ['string', 'required'],
            'street_number' => ['required', 'string'],
            'street' => ['required', 'string'],
            'ward_code' => ['required', 'exists:wards,code'],
            'district_code' => ['required', 'exists:districts,code'],
            'province_code' => ['required', 'exists:provinces,code'],
            'long' => ['required', 'numeric'],
            'lat' => ['required', 'numeric'],
            'phone_number' => ['string', new PhoneNumber, 'unique:addresses,phone_number', 'required'],
            'gender' => ['nullable', 'in:0,1,2'],
            'points' => ['nullable', 'integer']
        ];
    }
}
