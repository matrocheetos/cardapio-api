<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_pedido,
            'comanda' => $this->mesa->comanda,
            'produto' => $this->produto->nome,
            'observacao' => $this->observacao,
            'data_pedido' => $this->data_pedido,
            'status_pedido' => $this->status_pedido,
        ];
    }
}
