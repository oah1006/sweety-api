<?php

namespace App\Http\Requests\DeliveryAddress;

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
            'name' => ['nullable', 'string'],
            'house_number' => ['nullable', 'string'],
            'street' => ['nullable', 'string'],
            'ward' => ['nullable', 'string'],
            'district' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'phone_number' => ['string', 'nullable', new PhoneNumber, Rule::unique('addresses', 'phone_number')->ignore($this->addresses)],
            'is_default' => ['nullable', 'boolean'],
            'customer_id' => ['nullable', 'exists:customers,id']
        ];
    }
}
