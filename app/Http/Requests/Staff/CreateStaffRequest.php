<?php

namespace App\Http\Requests\Staff;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class CreateStaffRequest extends FormRequest
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
            'email' => ['email', 'required', 'string', 'unique:staff,email'],
            'password' => ['string', 'min:6', 'required'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'first_name' => ['required', 'string'],
            'last_name' => ['nullable', 'string'],
            'phone_number' => ['required', 'unique:staffs,phone_number',new PhoneNumber],
            'address' => ['required', 'string'],
            'position' => ['required', 'in:manager,employee'],
            'status' => ['required', 'in:active,disable']
        ];
    }
}
