<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
#[ORM\Table(name: 'categoria')]
#[OA\Schema(
    schema: "Categoria",
    description: "Representa uma categoria de produtos no cardápio",
    type: "object"
)]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[OA\Property(type: "integer", description: "ID único da categoria", example: 1)]
    private ?int $idCategoria = null;

    #[ORM\Column(type: "string", length: 255)]
    #[OA\Property(type: "string", description: "Descrição da categoria", example: "Bebidas")]
    private ?string $descricao = null;

    #[ORM\OneToMany(mappedBy: "categoria", targetEntity: Produto::class, cascade: ["persist", "remove"])]
    #[OA\Property(type: "array", items: new OA\Items(ref: "#/components/schemas/Produto"), description: "Lista de produtos pertencentes à categoria")]
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
}
