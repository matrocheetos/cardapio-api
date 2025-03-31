<?php

namespace App\Entity;

use App\Repository\MesaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MesaRepository::class)]
#[ORM\Table(name: 'MESA')]
class Mesa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $comanda = null;

    #[ORM\Column]
    private ?int $nro_mesa = null;

    #[ORM\Column]
    private ?int $status_pagamento = null;

    public function getComanda(): ?int
    {
        return $this->comanda;
    }

    public function setComanda(?int $comanda): static
    {
        $this->comanda = $comanda;

        return $this;
    }

    public function getNroMesa(): ?int
    {
        return $this->nro_mesa;
    }

    public function setNroMesa(int $nro_mesa): static
    {
        $this->nro_mesa = $nro_mesa;

        return $this;
    }

    public function getStatusPagamento(): ?int
    {
        return $this->status_pagamento;
    }

    public function setStatusPagamento(int $status_pagamento): static
    {
        $this->status_pagamento = $status_pagamento;

        return $this;
    }
}
