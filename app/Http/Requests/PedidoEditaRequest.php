<?php

namespace App\Http\Requests;

use App\Enums\StatusPedidoEnum;

class PedidoEditaRequest extends ApiRequest
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
            'comanda'       => 'required|integer|exists:mesa,comanda',
            'id_produto'    => 'required|integer|exists:produto,id_produto',
            'observacao'    => 'nullable|string|max:255',
            'status_pedido' => 'nullable|string|in:' . implode(',', StatusPedidoEnum::values())
        ];
    }

    public function messages(): array
    {
        return [
            'comanda.required'       => 'O número da comanda é obrigatório.',
            'comanda.exists'         => 'A comanda informada não existe.',
            'id_produto.required'    => 'O produto é obrigatório.',
            'id_produto.exists'      => 'O produto informado não existe.',
            'observacao.string'      => 'A observação deve ser um texto.',
            'observacao.max'         => 'A observação não pode ter mais que 255 caracteres.',
            'status_pedido.required' => 'O status do pedido é obrigatório.',
            'status_pedido.in'       => 'Status inválido. Valores permitidos: ' . implode(',', StatusPedidoEnum::values())
        ];
    }
}
