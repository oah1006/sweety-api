<?php

namespace App\Http\Requests\Store;

use App\Rules\PhoneNumber;
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
            'store_name' => ['nullable', 'string', Rule::unique('stores')->ignore($this->store)],
            'open_store' => ['nullable', 'date_format:H:i'],
            'close_store' => ['nullable', 'date_format:H:i'],
            'house_number' => ['nullable', 'string'],
            'street' => ['nullable', 'string'],
            'ward' => ['nullable', 'string'],
            'district' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'phone_number' => ['nullable', 'string', new PhoneNumber, 'unique:addresses,phone_number'],
        ];
    }
}
