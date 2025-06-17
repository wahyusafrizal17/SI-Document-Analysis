<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'role'                 => 'required',
            'password'              => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Nama tidak boleh kosong',
            'email.required'        => 'Email tidak boleh kosong',
            'role.required'         => 'Role tidak boleh kosong',
            'password.required'     => 'Password tidak boleh kosong',
        ];
    }
}
