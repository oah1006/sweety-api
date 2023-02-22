<?php

namespace App\Http\Requests\Customer;

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
            'address' => ['string', 'required'],
            'phone_number' => ['string', new PhoneNumber, 'unique:users,phone_number', 'required'],
        ];
    }
}
