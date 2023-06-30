<?php

namespace App\Http\Requests\Admin\Store;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class CreateStoreRequest extends FormRequest
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
            'store_name' => ['bail', 'required', 'string', 'unique:stores,store_name'],
            'open_store' => ['bail', 'required', 'date_format:H:i'],
            'close_store' => ['bail', 'required', 'date_format:H:i'],
            'street_number' => ['bail', 'required', 'string'],
            'street' => ['bail', 'required', 'string'],
            'ward_code' => ['bail', 'required', 'exists:wards,code'],
            'district_code' => ['bail', 'required', 'exists:districts,code'],
            'province_code' => ['bail', 'required', 'exists:provinces,code'],
            'long' => ['bail', 'required', 'numeric'],
            'lat' => ['bail', 'required', 'numeric'],
            'detail_stores' => ['nullable', 'array'],
            'detail_stores.*' => ['file', 'mimes:jpg,jpeg,png'],
            'phone_number' => ['bail', 'nullable', 'string', new PhoneNumber, 'unique:addresses,phone_number'],
        ];
    }
}
