<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:80',
            'email' => 'required|min:5|max:80',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.*' => 'El nombre debe tener minimo 5 caracteres y maximo 80',
            'email.*' => 'El correo debe tener minimo 5 caracteres y maximo 80',
            'password.*' => 'la contraseña es requerida',
        ];
    }
}
