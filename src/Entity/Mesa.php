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
    private ?int $nroMesa = null;

    #[ORM\Column]
    private ?int $statusPagamento = null;

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
        return $this->nroMesa;
    }

    public function setNroMesa(int $nroMesa): static
    {
        $this->nroMesa = $nroMesa;

        return $this;
    }

    public function getStatusPagamento(): ?int
    {
        return $this->statusPagamento;
    }

    public function setStatusPagamento(int $statusPagamento): static
    {
        $this->statusPagamento = $statusPagamento;

        return $this;
    }
}
