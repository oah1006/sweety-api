<?php

namespace App\Http\Requests\Store;

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
            'store_name' => ['required', 'string', 'unique:stores,store_name'],
            'open_store' => ['required', 'date_format:H:i'],
            'close_store' => ['required', 'date_format:H:i'],
            'street_number' => ['required', 'string'],
            'street' => ['required', 'string'],
            'ward_code' => ['required', 'exists:wards,code'],
            'district_code' => ['required', 'exists:districts,code'],
            'province_code' => ['required', 'exists:provinces,code'],
            'long' => ['required', 'numeric'],
            'lat' => ['required', 'numeric'],
            'phone_number' => ['nullable', 'string', new PhoneNumber, 'unique:addresses,phone_number'],
        ];
    }
}
