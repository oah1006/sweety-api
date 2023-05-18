<?php

namespace App\Http\Requests\Admin\Store;

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
            'street_number' => ['nullable', 'string'],
            'street' => ['nullable', 'string'],
            'ward_code' => ['nullable', 'exists:wards,code'],
            'district_code' => ['nullable', 'exists:districts,code'],
            'province_code' => ['nullable', 'exists:provinces,code'],
            'long' => ['nullable', 'numeric'],
            'lat' => ['nullable', 'numeric'],
            'phone_number' => ['nullable', 'string', new PhoneNumber, 'unique:addresses,phone_number'],
        ];
    }
}
