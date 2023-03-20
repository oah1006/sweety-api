<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStoreRequest extends FormRequest
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
            'name' => ['nullable', 'string', Rule::unique('stores')->ignore($this->store)],
            'address' => ['nullable', 'string', Rule::unique('stores')->ignore($this->store)],
            'open_store' => ['nullable', 'date_format:H:i'],
            'close_store' => ['nullable', 'date_format:H:i']
        ];
    }
}
