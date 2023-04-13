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
            'store_name' => ['required', 'string', 'unique:stores,name'],
            'open_store' => ['required', 'date_format:H:i'],
            'close_store' => ['required', 'date_format:H:i'],
            'house_number' => ['required', 'string'],
            'street' => ['required', 'string'],
            'ward' => ['required', 'string'],
            'district' => ['required', 'string'],
            'city' => ['required', 'string'],
            'phone_number' => ['string', new PhoneNumber, 'unique:addresses,phone_number', 'required'],
        ];
    }
}
