<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
#[ORM\Table(name: 'PEDIDO')]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_pedido = null;

    #[ORM\Column]
    private ?int $comanda = null;

    #[ORM\Column]
    private ?int $id_produto = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observacao = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_pedido = null;

    #[ORM\Column(length: 10)]
    private ?string $status_pedido = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPedido(): ?int
    {
        return $this->id_pedido;
    }

    public function setIdPedido(int $id_pedido): static
    {
        $this->id_pedido = $id_pedido;

        return $this;
    }

    public function getComanda(): ?int
    {
        return $this->comanda;
    }

    public function setComanda(int $comanda): static
    {
        $this->comanda = $comanda;

        return $this;
    }

    public function getIdProduto(): ?int
    {
        return $this->id_produto;
    }

    public function setIdProduto(int $id_produto): static
    {
        $this->id_produto = $id_produto;

        return $this;
    }

    public function getObservacao(): ?string
    {
        return $this->observacao;
    }

    public function setObservacao(?string $observacao): static
    {
        $this->observacao = $observacao;

        return $this;
    }

    public function getDataPedido(): ?\DateTimeInterface
    {
        return $this->data_pedido;
    }

    public function setDataPedido(\DateTimeInterface $data_pedido): static
    {
        $this->data_pedido = $data_pedido;

        return $this;
    }

    public function getStatusPedido(): ?string
    {
        return $this->status_pedido;
    }

    public function setStatusPedido(string $status_pedido): static
    {
        $this->status_pedido = $status_pedido;

        return $this;
    }
}
