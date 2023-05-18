<?php

namespace App\Http\Requests\Admin\Customer;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
            'email' => ['required', 'email:rfc,dns', 'string', Rule::unique('users')->ignore($this->customer->user->getKey())],
            'full_name' => ['string', 'required'],
            'house_number' => ['nullable', 'string'],
            'street' => ['nullable', 'string'],
            'ward' => ['nullable', 'string'],
            'district' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'phone_number' => ['nullable', new PhoneNumber, Rule::unique('addresses', 'phone_number')->ignore($this->staff->address->getKey())],
        ];
    }
}
