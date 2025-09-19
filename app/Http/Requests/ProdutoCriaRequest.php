<?php

namespace App\Http\Requests;

class ProdutoCriaRequest extends ApiRequest
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
            'nome'           => 'required|string|max:255',
            'descricao'      => 'required|string|max:255',
            'imagem'         => 'nullable|image|max:255',
            'preco'          => 'required|numeric|min:0|decimal:0,2',
            'preco_desconto' => 'nullable|numeric|min:0|decimal:0,2',
            'eh_vegano'      => 'required|boolean',
            'eh_sem_gluten'  => 'required|boolean',
            'em_estoque'     => 'required|boolean',
            'porcoes'        => 'required|integer|min:1',
            'id_categoria'   => 'required|integer|exists:categoria,id_categoria'
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'           => 'O nome é obrigatório',
            'nome.max'                => 'O nome deve ter no máximo 255 caracteres',
            'descricao.required'      => 'A descrição é obrigatória',
            'descricao.max'           => 'A descrição deve ter no máximo 255 caracteres',
            'imagem.url'              => 'Informe uma URL válida para a imagem',
            'preco.required'          => 'O preço é obrigatório',
            'preco.numeric'           => 'O preço deve ser numérico',
            'preco.min'               => 'O preço deve ser maior que zero',
            'preco.decimal'           => 'O preço deve ter no máximo 2 casas decimais',
            'preco_desconto.numeric'  => 'O preço com desconto deve ser numérico',
            'preco_desconto.min'      => 'O preço com desconto deve ser maior que zero',
            'preco_desconto.decimal'  => 'O preço com desconto deve ter no máximo 2 casas decimais',
            'eh_vegano.required'      => 'Informe se o produto é vegano',
            'eh_vegano.boolean'       => 'O campo vegano deve ser verdadeiro ou falso',
            'eh_sem_gluten.required'  => 'Informe se o produto não contém glúten',
            'eh_sem_gluten.boolean'   => 'O campo sem glúten deve ser verdadeiro ou falso',
            'em_estoque.required'     => 'Informe se o produto está em estoque',
            'em_estoque.boolean'      => 'O campo em estoque deve ser verdadeiro ou falso',
            'porcoes.required'        => 'O número de porções é obrigatório',
            'porcoes.integer'         => 'O número de porções deve ser um inteiro',
            'porcoes.min'             => 'Deve ter pelo menos 1 porção',
            'id_categoria.required'   => 'A categoria é obrigatória',
            'id_categoria.exists'     => 'A categoria informada não existe'
        ];
    }
}
