<?php

namespace App\Http\Requests\Staff;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
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
            'email' => ['required', 'email:rfc,dns', 'string', Rule::unique('users')->ignore($this->staff->user->getKey())],
            'password' => ['required', 'string', 'min:6'],
            'full_name' => ['string', 'required'],
            'address' => ['string', 'required'],
            'phone_number' => ['string', new PhoneNumber],
            'is_active' => ['nullable', 'boolean'],
            'is_admin' => ['nullable', 'boolean']
        ];
    }
}
