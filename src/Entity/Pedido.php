<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use App\Enum\StatusPedido;
use DateTimeInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
#[ORM\Table(name: 'pedido')]
#[OA\Schema(
    schema: "Pedido",
    description: "Modelo de Pedido no Cardápio",
    type: "object"
)]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[OA\Property(description: "ID do pedido", example: 1)]
    private ?int $idPedido = null;

    #[ORM\ManyToOne(targetEntity: Mesa::class)]
    #[ORM\JoinColumn(name: "comanda", referencedColumnName: "comanda", nullable: false, onDelete: "CASCADE")]
    #[OA\Property(description: "Mesa associada ao pedido", example: 1)]
    private Mesa $mesa;

    #[ORM\ManyToOne(targetEntity: Produto::class)]
    #[ORM\JoinColumn(name: "id_produto", referencedColumnName: "id_produto", nullable: false, onDelete: "CASCADE")]
    #[OA\Property(description: "Produto solicitado", example: 1)]
    private Produto $produto;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[OA\Property(description: "Observação opcional sobre o pedido", example: "Sem gelo")]
    private ?string $observacao = null;

    #[ORM\Column(type: "datetime")]
    #[OA\Property(description: "Data e hora do pedido", example: "2024-03-30T14:00:00Z")]
    private ?DateTimeInterface $dataPedido = null;

    #[ORM\Column(type: "string", length: 10, enumType: StatusPedido::class)]
    #[OA\Property(description: "Status do pedido", example: "PREPARANDO", enum: ["PREPARANDO", "PRONTO", "ENTREGUE"])]
    private StatusPedido $statusPedido;

    public function __construct(Mesa $mesa, Produto $produto, ?string $observacao = null)
    {
        $this->mesa = $mesa;
        $this->produto = $produto;
        $this->observacao = $observacao;
        $this->dataPedido = new DateTime();
        $this->statusPedido = StatusPedido::PREPARANDO;
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

    public function getMesa(): ?Mesa
    {
        return $this->mesa;
    }

    public function setMesa(Mesa $mesa): static
    {
        $this->comanda = $mesa;

        return $this;
    }

    public function getProduto(): ?Produto
    {
        return $this->produto;
    }

    public function setProduto(Produto $produto): static
    {
        $this->produto = $produto;

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

    public function setDataPedido(DateTimeInterface|string $dataPedido): static
    {
        if (is_string($dataPedido)) {
            $dataPedido = new DateTime($dataPedido);
        }
        $this->dataPedido = $dataPedido;
        return $this;
    }

    public function getStatusPedido(): ?StatusPedido
    {
        return $this->statusPedido;
    }

    public function setStatusPedido(StatusPedido|string $statusPedido): static
    {
        if (is_string($statusPedido)) {
            $statusPedido = StatusPedido::tryFrom($statusPedido);
            
            if (!$statusPedido) {
                throw new \InvalidArgumentException("Status inválido: $statusPedido. Valores permitidos: " . implode(', ', StatusPedido::values()));
            }
        }
    
        $this->statusPedido = $statusPedido;
    
        return $this;
    }
}
