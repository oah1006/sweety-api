<?php

namespace App\Http\Requests\Admin\Auth;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateProfileRequest extends FormRequest
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
            'email' => ['nullable', 'email:rfc,dns', 'string', Rule::unique('users')
                ->ignore(auth()->user()->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'full_name' => ['string', 'nullable'],
            'address' => ['string', 'nullable'],
            'phone_number' => ['string', 'nullable', new PhoneNumber, Rule::unique('users')
                ->ignore(auth()->user()->id)],
            'is_active' => ['nullable', 'boolean'],
            'role' => ['nullable ']
        ];
    }
}
