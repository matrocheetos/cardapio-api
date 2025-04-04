<?php

namespace App\Entity;

use App\Repository\MesaRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\Entity(repositoryClass: MesaRepository::class)]
#[ORM\Table(name: 'mesa')]
#[OA\Schema(
    schema: "Mesa",
    description: "Representa uma mesa no restaurante",
    type: "object"
)]
class Mesa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[OA\Property(type: "integer", description: "ID único da mesa (comanda)", example: 1)]
    private ?int $comanda = null;

    #[ORM\Column(type: "integer")]
    #[OA\Property(type: "integer", description: "Número da mesa", example: 4)]
    private ?int $nroMesa = null;

    #[ORM\Column(type: "boolean", options: ["default" => 0])]
    #[OA\Property(type: "boolean", description: "Status de pagamento (false = não pago, true = pago)", example: false)]
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

    public function getStatusPagamento(): bool
    {
        return $this->statusPagamento;
    }

    public function setStatusPagamento(bool|int $statusPagamento): static
    {
        $this->statusPagamento = (bool) $statusPagamento;
        return $this;
    }
}
