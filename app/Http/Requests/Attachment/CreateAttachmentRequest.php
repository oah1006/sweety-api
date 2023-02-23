<?php

namespace App\Http\Requests\Attachment;

use Illuminate\Foundation\Http\FormRequest;

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
            'file' => ['nullable', 'mimes:jpg,jpeg,png'],
            'attachmentable_type' => ['required', 'string'],
            'attachmentable_id' => ['required', 'string'],
            'directory' => ['required', 'string']
        ];
    }
}
