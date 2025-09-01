<?php

namespace App\Http\Requests;

use App\Enums\StatusPagamentoEnum;

class MesaEditaRequest extends ApiRequest
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
            'nro_mesa'         => 'required|integer|min:1|unique:mesa,nro_mesa',
            'status_pagamento' => 'nullable|string|in:' . implode(',', StatusPagamentoEnum::values())
        ];
    }

    public function messages(): array
    {
        return [
            'nro_mesa.required'       => 'O número da mesa é obrigatório.',
            'nro_mesa.integer'        => 'O número da mesa deve ser um número inteiro.',
            'nro_mesa.min'            => 'O número da mesa deve ser maior que zero.',
            'nro_mesa.unique'         => 'Já existe uma mesa com este número.',
            'status_pagamento.string' => 'O status de pagamento deve ser um texto.',
            'status_pagamento.in'     => 'Status de pagamento inválido. Valores permitidos: ' . implode(', ', StatusPagamentoEnum::values())
        ];
    }
}
