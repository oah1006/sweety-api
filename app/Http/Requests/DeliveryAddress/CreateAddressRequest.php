<?php

namespace App\Http\Requests\DeliveryAddress;

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
            'name' => ['nullable', 'string'],
            'house_number' => ['required', 'string'],
            'street' => ['required', 'string'],
            'ward' => ['required', 'string'],
            'district' => ['required', 'string'],
            'city' => ['required', 'string'],
            'phone_number' => ['string', new PhoneNumber, 'unique:addresses,phone_number', 'required'],
            'is_default' => ['required', 'boolean'],
            'customer_id' => ['required', 'exists:customers,id']
        ];
    }
}
