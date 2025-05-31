<?php

namespace App\Models;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Categoria
{
    private ?int $idCategoria = null;

    private ?string $descricao = null;

    private Collection $produtos;

    public function __construct()
    {
        $this->produtos = new ArrayCollection();
    }

    public function getIdCategoria(): ?int
    {
        return $this->idCategoria;
    }

    public function setIdCategoria(int $idCategoria): static
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): static
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getProdutos(): Collection
    {
        return $this->produtos;
    }

    public function addProduto(Produto $produto): static
    {
        if (!$this->produtos->contains($produto)) {
            $this->produtos->add($produto);
            $produto->setCategoria($this);
        }
        return $this;
    }

    public function removeProduto(Produto $produto): static
    {
        if ($this->produtos->contains($produto)) {
            $this->produtos->removeElement($produto);
        }
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id_categoria' => $this->getIdCategoria(),
            'descricao'    => $this->getDescricao()
        ];
    }

    public static function fromArray(array $data, int $id = null): self
    {
        if (!isset($data['descricao'])) {
            throw new \InvalidArgumentException('Dados incompletos ou inválidos para a categoria.');
        }

        $categoria = new self();
        $categoria->setDescricao($data['descricao']);

        if (isset($id)) {
            $categoria->setIdCategoria($id);
        }

        return $categoria;
    }
}
