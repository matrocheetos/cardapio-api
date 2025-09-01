<?php

namespace App\Http\Requests;

class CategoriaCriaRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'descricao' => 'required|string|max:255|unique:categoria,descricao'
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required' => 'A descrição da categoria é obrigatória.',
            'descricao.string'   => 'A descrição deve ser um texto.',
            'descricao.max'      => 'A descrição não pode ter mais que 255 caracteres.',
            'descricao.unique'   => 'A categoria já existe.'
        ];
    }
}
