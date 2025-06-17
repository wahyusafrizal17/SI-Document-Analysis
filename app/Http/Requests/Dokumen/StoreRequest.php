<?php

namespace App\Http\Requests\Dokumen;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'document_name'          => 'required',
            'document_url'          => 'required',
        ];
    }

    public function messages()
    {
        return [
            'document_name.required'              => 'Nama dokumen tidak boleh kosong',
            'document_url.required'               => 'Url dokumen tidak boleh kosong',
        ];
    }
}
