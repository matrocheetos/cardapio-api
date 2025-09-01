<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PedidoProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_pedido'     => $this->id_pedido,
            'data_pedido'   => Carbon::parse($this->data_pedido, 'UTC')->setTimezone('America/Sao_Paulo')->format('H:i:s d/m/Y'),
            'status_pedido' => $this->status_pedido,
            'observacao'    => $this->observacao,
            'produto'       => [
                'id'             => $this->produto->id_produto,
                'nome'           => $this->produto->nome,
                'descricao'      => $this->produto->descricao,
                'imagem'         => $this->produto->imagem,
                'preco'          => (float) ($this->produto->preco_desconto ?? $this->produto->preco),
                'eh_sem_gluten'  => (bool) $this->produto->eh_sem_gluten,
                'eh_vegano'      => (bool) $this->produto->eh_vegano
            ]
        ];
    }
}
