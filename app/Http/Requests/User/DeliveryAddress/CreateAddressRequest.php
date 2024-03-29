<?php

namespace App\Http\Requests\User\DeliveryAddress;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class CreateAddressRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'street_number' => ['required', 'string'],
            'street' => ['required', 'string'],
            'ward_code' => ['required', 'exists:wards,code'],
            'district_code' => ['required', 'exists:districts,code'],
            'province_code' => ['required', 'exists:provinces,code'],
            'long' => ['nullable', 'numeric'],
            'lat' => ['nullable', 'numeric'],
            'phone_number' => ['bail', new PhoneNumber, 'unique:addresses,phone_number', 'required'],
            'customer_id' => ['nullable', 'exists:customer,id'],
            'meta' => ['nullable', 'array']
        ];
    }
}
