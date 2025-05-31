<?php

namespace App\Models;

use App\Repository\MesaRepository;
class Mesa
{
    private ?int $comanda = null;

    private ?int $nroMesa = null;

    private bool $statusPagamento = false;

    public function getComanda(): ?int
    {
        return $this->comanda;
    }

    public function setComanda(?int $comanda): static
    {
        $this->comanda = $comanda;

        return $this;
    }

    public function getNroMesa(): int
    {
        return $this->nroMesa;
    }

    public function setNroMesa(int $nroMesa): static
    {
        $this->nroMesa = $nroMesa;

        return $this;
    }

    public function getStatusPagamento(): int
    {
        return $this->statusPagamento ? 1 : 0;
    }

    public function setStatusPagamento(bool|int $statusPagamento): static
    {
        $this->statusPagamento = (bool) $statusPagamento;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'comanda'          => $this->getComanda(),
            'nro_mesa'         => $this->getNroMesa(),
            'status_pagamento' => $this->getStatusPagamento(),
        ];
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['nro_mesa'])) {
            throw new \InvalidArgumentException('Dados incompletos ou inválidos para a mesa.');
        }

        $mesa = new self();
        $mesa->setNroMesa($data['nro_mesa']);

        if (isset($data['comanda'], $data['status_pagamento'])) {
            $mesa->setComanda($data['comanda']);
            $mesa->setStatusPagamento($data['status_pagamento']);
        } else {
            $mesa->setStatusPagamento(false);
        }

        return $mesa;
    }
}
