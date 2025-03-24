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
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idMesa = null;

    #[ORM\Column(nullable: true)]
    private ?int $comanda = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pedido = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMesa(): ?int
    {
        return $this->idMesa;
    }

    public function setIdMesa(int $idMesa): static
    {
        $this->idMesa = $idMesa;

        return $this;
    }

    public function getComanda(): ?int
    {
        return $this->comanda;
    }

    public function setComanda(?int $comanda): static
    {
        $this->comanda = $comanda;

        return $this;
    }

    public function getPedido(): ?string
    {
        return $this->pedido;
    }

    public function setPedido(?string $pedido): static
    {
        $this->pedido = $pedido;

        return $this;
    }
}
