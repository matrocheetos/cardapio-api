<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_produto'     => $this->id_produto,
            'id_categoria'   => $this->categoria->id_categoria,
            'nome'           => $this->nome,
            'descricao'      => $this->descricao,
            'imagem'         => $this->imagem,
            'preco'          => $this->preco,
            'preco_desconto' => $this->preco_desconto,
            'eh_vegano'      => $this->eh_vegano,
            'eh_sem_gluten'  => $this->eh_sem_gluten,
            'em_estoque'     => $this->em_estoque,
            'porcoes'        => $this->porcoes,
        ];
    }
}
