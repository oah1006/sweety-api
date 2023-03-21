<?php

namespace App\Http\Requests\Auth\Otp;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
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
            'email' => ['string', 'email:rfc,dns', 'exists:users,email'],
            'otp' => ['required', 'string', 'min:6']
        ];
    }
}
