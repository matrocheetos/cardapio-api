<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
#[ORM\Table(name: 'PRODUTO')]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[OA\Property(type: "integer", description: "ID do produto", example: 1)]
    private ?int $idProduto = null;

    #[ORM\Column(length: 255)]
    #[OA\Property(description: "Nome do produto", example: "Salada Ceasar")]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    #[OA\Property(description: "Descrição do produto", example: "Salada com molho especial e croutons")]
    private ?string $descricao = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[OA\Property(description: "Caminho para uma imagem", example: "https://cardapio.com/imagem.jpg")]
    private ?string $imagem = null;

    #[ORM\Column]
    #[OA\Property(description: "Preço do produto", example: 25.90)]
    private ?float $preco = null;

    #[ORM\Column]
    #[OA\Property(description: "Se o produto não possui ingredientes de origem animal", example: 0)]
    private ?bool $ehVegano = null;

    #[ORM\Column]
    #[OA\Property(description: "Se o produto não contém glúten", example: 0)]
    private ?bool $ehSemGluten = null;

    #[ORM\Column]
    #[OA\Property(description: "Recomendação de número de porções por produto", example: 1)]
    private ?int $porcoes = null;

    #[ORM\Column]
    #[OA\Property(description: "Categoria do produto (ID_CATEGORIA)", example: 1)]
    private ?int $categoria = null;

    public function getIdProduto(): ?int
    {
        return $this->idProduto;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

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

    public function getImagem(): ?string
    {
        return $this->imagem;
    }

    public function setImagem(?string $imagem): static
    {
        $this->imagem = $imagem;

        return $this;
    }

    public function getPreco(): ?float
    {
        return $this->preco;
    }

    public function setPreco(float $preco): static
    {
        $this->preco = $preco;

        return $this;
    }

    public function isEhVegano(): ?bool
    {
        return $this->ehVegano;
    }

    public function setEhVegano(bool $ehVegano): static
    {
        $this->ehVegano = $ehVegano;

        return $this;
    }

    public function isEhSemGluten(): ?bool
    {
        return $this->ehSemGluten;
    }

    public function setEhSemGluten(bool $ehSemGluten): static
    {
        $this->ehSemGluten = $ehSemGluten;

        return $this;
    }

    public function getPorcoes(): ?int
    {
        return $this->porcoes;
    }

    public function setPorcoes(int $porcoes): static
    {
        $this->porcoes = $porcoes;

        return $this;
    }

    public function getCategoria(): ?int
    {
        return $this->categoria;
    }

    public function setCategoria(int $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }


}
