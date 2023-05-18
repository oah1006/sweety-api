<?php

namespace App\Http\Requests\User\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $stopOnFirstFailure = true;

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
            'email' => ['bail' ,'required', 'email:rfc,dns', 'string'],
            'password' => ['bail' ,'required', 'string', 'min:6'],
            'full_name' => ['bail', 'required', 'string'],
            'gender' => ['bail', 'required', 'in:0,1,2']
        ];
    }
}
