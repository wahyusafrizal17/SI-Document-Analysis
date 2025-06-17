<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'name'                  => 'required',
            'email'                 => 'required',
            'level'                 => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Nama tidak boleh kosong',
            'email.required'        => 'Email tidak boleh kosong',
            'level.required'        => 'Level tidak boleh kosong',
        ];
    }
}
