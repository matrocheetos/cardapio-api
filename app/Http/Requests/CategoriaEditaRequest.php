<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class CategoriaEditaRequest extends ApiRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'descricao' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categoria', 'descricao')->ignore($this->route('id'), 'id_categoria'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required' => 'A descrição da categoria é obrigatória.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição não pode ter mais que 255 caracteres.',
            'descricao.unique' => 'A categoria já existe.',
        ];
    }
}
