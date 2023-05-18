<?php

namespace App\Http\Requests\Admin\Attachment;

use App\Enums\AttachmentTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateAttachmentRequest extends FormRequest
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
            'file' => ['nullable', 'array'],
            'file.*' => ['file', 'mimes:jpg,jpeg,png'],
            'type' => ['required', 'string', new Enum(AttachmentTypes::class)]
        ];
    }
}
