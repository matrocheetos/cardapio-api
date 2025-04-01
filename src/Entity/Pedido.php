<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use App\Enum\StatusPedido;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
#[ORM\Table(name: 'PEDIDO')]
#[OA\Schema(
    schema: "Pedido",
    description: "Modelo de Pedido no Cardápio",
    type: "object"
)]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[OA\Property(description: "ID do pedido", example: 1)]
    private ?int $idPedido = null;

    #[ORM\Column]
    #[OA\Property(description: "Número da comanda associada ao pedido", example: 1)]
    private ?int $comanda = null;

    #[ORM\Column]
    #[OA\Property(description: "Produto pedido (ID_PRODUTO)", example: 1)]
    private ?int $idProduto = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[OA\Property(description: "Observação sobre o pedido", example: "Sem gelo")]
    private ?string $observacao = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[OA\Property(description: "Data e hora do pedido", example: "2024-03-30T14:00:00Z")]
    private ?DateTimeInterface $dataPedido = null;

    #[ORM\Column(type: "string", length: 10, enumType: StatusPedido::class)]
    #[OA\Property(description: "Status do pedido", example: "PREPARANDO", enum: ["PREPARANDO", "PRONTO", "ENTREGUE"])]
    private ?StatusPedido $statusPedido = null;

    public function __construct(int $comanda, int $idProduto, ?string $observacao = null)
    {
        $this->comanda = $comanda;
        $this->idProduto = $idProduto;
        $this->observacao = $observacao;
    }

    public function getIdPedido(): ?int
    {
        return $this->idPedido;
    }

    public function setIdPedido(int $idPedido): static
    {
        $this->id_pedido = $idPedido;

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
        return $this->idProduto;
    }

    public function setIdProduto(int $idProduto): static
    {
        $this->idProduto = $idProduto;

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

    public function getDataPedido(): ?DateTimeInterface
    {
        return $this->dataPedido;
    }

    public function setDataPedido(string $dataPedido): static
    {
        $this->dataPedido = new \DateTime($dataPedido);

        return $this;
    }

    public function getStatusPedido(): ?StatusPedido
    {
        return $this->statusPedido;
    }

    public function setStatusPedido(StatusPedido|string $statusPedido): static
    {
        if (is_string($statusPedido)) {
            if (!StatusPedido::tryFrom($statusPedido)) {
                throw new \InvalidArgumentException("Status inválido: $statusPedido. Valores permitidos: PREPARANDO, PRONTO, ENTREGUE.");
            }
            $statusPedido = StatusPedido::from($statusPedido);
        }
    
        $this->statusPedido = $statusPedido;
    
        return $this;
    }
}
