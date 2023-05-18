<?php

namespace App\Http\Requests\Admin\DeliveryAddress;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->profile->id == $this->delivery_address->customer_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'string'],
            'street_number' => ['nullable', 'string'],
            'street' => ['nullable', 'string'],
            'ward_code' => ['nullable', 'exists:wards,code'],
            'district_code' => ['nullable', 'exists:districts,code'],
            'province_code' => ['nullable', 'exists:provinces,code'],
            'long' => ['nullable', 'numeric'],
            'lat' => ['nullable', 'numeric'],
            'phone_number' => ['string', 'nullable', new PhoneNumber, Rule::unique('addresses', 'phone_number')->ignore($this->delivery_address)],
            'is_default' => ['nullable', 'boolean'],
        ];
    }
}
