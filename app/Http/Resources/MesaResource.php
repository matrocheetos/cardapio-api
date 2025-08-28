<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MesaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comanda'          => $this->comanda,
            'nro_mesa'         => $this->nro_mesa,
            'status_pagamento' => $this->status_pagamento
        ];
    }
}
