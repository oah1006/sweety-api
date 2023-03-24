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
            'email' => ['nullable', 'email:rfc,dns', 'string', Rule::unique('users')->ignore($this->staff->user->getKey())],
            'full_name' => ['string', 'nullable'],
            'address' => ['string', 'nullable'],
            'phone_number' => ['string', 'nullable', new PhoneNumber, Rule::unique('users')->ignore($this->staff->user->getKey())],
            'is_active' => ['nullable', 'boolean'],
            'role' => ['nullable'],
            'avatar' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
            'store_id' => ['nullable', 'exists:stores,id']
        ];
    }
}
