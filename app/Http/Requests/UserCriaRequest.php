<?php

namespace App\Http\Requests;

class UserCriaRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password|min:8'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'             => 'O nome é obrigatório.',
            'name.string'               => 'O nome deve ser um texto.',
            'name.max'                  => 'O nome não pode ter mais que 255 caracteres.',
            'email.required'            => 'O e-mail é obrigatório.',
            'email.email'               => 'Informe um e-mail válido.',
            'email.unique'              => 'Este e-mail já está em uso.',
            'password.required'         => 'A senha é obrigatória.',
            'password.string'           => 'A senha deve ser um texto.',
            'password.min'              => 'A senha deve ter no mínimo 8 caracteres.',
            'confirm_password.required' => 'A confirmação de senha é obrigatória.',
            'confirm_password.string'   => 'A confirmação de senha deve ser um texto.',
            'confirm_password.same'     => 'A confirmação de senha deve ser igual à senha.',
            'confirm_password.min'      => 'A confirmação de senha deve ter no mínimo 8 caracteres.'
        ];
    }
}
