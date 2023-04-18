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
            'email' => ['required', 'email:rfc,dns', 'string', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'full_name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string', new PhoneNumber, 'unique:staff,phone_number'],
            'is_active' => ['nullable', 'boolean'],
            'role' => ['required', 'in:administrator,manager,employee,shipper'],
            'avatar' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
            'store_id' => ['required', 'exists:stores,id'],
        ];
    }
}
