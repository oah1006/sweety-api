<?php

namespace App\Http\Requests\Admin\Staff;

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
            'email' => ['bail', 'required', 'email:rfc,dns', 'string', 'unique:users,email'],
            'password' => ['bail','required', 'string', 'min:6'],
            'full_name' => ['bail','required', 'string'],
            'address' => ['bail','required', 'string'],
            'phone_number' => ['bail','bail', 'required', 'string', new PhoneNumber, 'unique:staff,phone_number'],
            'is_active' => ['bail','required', 'boolean'],
            'role' => ['bail','required', 'in:administrator,manager,employee,shipper'],
            'avatar' => ['bail','nullable', 'file', 'mimes:jpg,jpeg,png'],
            'store_id' => ['bail','required', 'exists:stores,id'],
        ];
    }
}
