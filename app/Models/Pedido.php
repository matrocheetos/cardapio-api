<?php

namespace App\Models;

use App\Repositories\PedidoRepository;
use App\Enums\StatusPedidoEnum;
use DateTimeInterface;
use DateTime;

class Pedido
{
    private ?int $idPedido = null;

    private ?Mesa $mesa = null;

    private ?Produto $produto = null;
    private ?string $observacao = null;

    private ?DateTimeInterface $dataPedido = null;

    private StatusPedidoEnum $statusPedido;

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
        $this->mesa = $mesa;

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

    public function getDataPedido(): ?string
    {
        return $this->dataPedido->format('Y-m-d H:i:s');
    }

    public function setDataPedido(DateTimeInterface|string $dataPedido): static
    {
        if (is_string($dataPedido)) {
            $dataPedido = new DateTime($dataPedido);
        }
        $this->dataPedido = $dataPedido;
        return $this;
    }

    public function getStatusPedido(): ?string
    {
        return $this->statusPedido->value;
    }

    public function setStatusPedido(StatusPedidoEnum|string $statusPedido): static
    {
        if (is_string($statusPedido)) {
            $statusPedido = StatusPedidoEnum::tryFrom($statusPedido);
            
            if (!$statusPedido) {
                throw new \InvalidArgumentException("Status inválido: $statusPedido. Valores permitidos: " . implode(', ', StatusPedidoEnum::values()));
            }
        }
    
        $this->statusPedido = $statusPedido;
    
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id_pedido'     => $this->getIdPedido(),
            'comanda'       => $this->getMesa()->getComanda(),
            'produto'       => $this->getProduto()->toArray(),
            'observacao'    => $this->getObservacao(),
            'data_pedido'   => $this->getDataPedido(),
            'status_pedido' => $this->getStatusPedido()
        ];
    }

    public static function fromArray(array $data, int $id = null): self
    {
        if (!isset($data['comanda'], $data['id_produto'])) {
            throw new \InvalidArgumentException('Dados incompletos ou inválidos para o pedido.');
        }

        $pedido = new self();
        $pedido
            ->setMesa((new Mesa())->setComanda($data['comanda']))
            ->setProduto((new Produto())->setIdProduto($data['id_produto']))
        ;

        if(isset($data['observacao'])) {
            $pedido->setObservacao($data['observacao']);
        }

        if (isset($data['data_pedido'], $data['status_pedido'])) {
            $pedido->setDataPedido($data['data_pedido']);
            $pedido->setIdPedido($data['id_pedido']);
        } else {
            $pedido->setDataPedido(new DateTime());
            $pedido->setStatusPedido(StatusPedidoEnum::PREPARANDO);
        }



        if (isset($id)) {
            $pedido->setIdPedido($id);
        }

        return $pedido;
    }


}
