<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
#[ORM\Table(name: 'produto')]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[OA\Property(type: "integer", description: "ID do produto", example: 1)]
    private ?int $idProduto = null;

    #[ORM\Column(type: "string", length: 255)]
    #[OA\Property(description: "Nome do produto", example: "Salada Ceasar")]
    private string $nome;

    #[ORM\Column(type: "string", length: 255)]
    #[OA\Property(description: "Descrição do produto", example: "Salada com molho especial e croutons")]
    private string $descricao;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[OA\Property(description: "Caminho para uma imagem", example: "https://cardapio.com/imagem.jpg")]
    private ?string $imagem = null;

    #[ORM\Column(type: "float")]
    #[OA\Property(description: "Preço do produto", example: 25.90)]
    private float $preco;

    #[ORM\Column(type: "boolean", options: ["default" => false])]
    #[OA\Property(description: "Se o produto não possui ingredientes de origem animal", example: 0)]
    private bool $ehVegano = false;

    #[ORM\Column(type: "boolean", options: ["default" => false])]
    #[OA\Property(description: "Se o produto não contém glúten", example: 0)]
    private bool $ehSemGluten = false;

    #[ORM\Column(type: "integer")]
    #[OA\Property(description: "Recomendação de número de porções por produto", example: 1)]
    private int $porcoes;

    #[ORM\ManyToOne(targetEntity: Categoria::class, inversedBy: "produtos")]
    #[ORM\JoinColumn(name: "id_categoria", referencedColumnName: "id_categoria", nullable: false, onDelete: "CASCADE")]
    #[OA\Property(description: "Categoria do produto", example: 1)]
    private Categoria $categoria;

    public function getIdProduto(): ?int
    {
        return $this->idProduto;
    }

    public function setIdProduto(int $idProduto): static
    {
        $this->idProduto = $idProduto;

        return $this;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDescricao(): string
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

    public function getPreco(): float
    {
        return $this->preco;
    }

    public function setPreco(float $preco): static
    {
        $this->preco = $preco;

        return $this;
    }

    public function isEhVegano(): bool
    {
        return $this->ehVegano;
    }

    public function setEhVegano(bool $ehVegano): static
    {
        $this->ehVegano = $ehVegano;

        return $this;
    }

    public function isEhSemGluten(): bool
    {
        return $this->ehSemGluten;
    }

    public function setEhSemGluten(bool $ehSemGluten): static
    {
        $this->ehSemGluten = $ehSemGluten;

        return $this;
    }

    public function getPorcoes(): int
    {
        return $this->porcoes;
    }

    public function setPorcoes(int $porcoes): static
    {
        $this->porcoes = $porcoes;

        return $this;
    }

    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id_produto'    => $this->getIdProduto(),
            'nome'          => $this->getNome(),
            'descricao'     => $this->getDescricao(),
            'imagem'        => $this->getImagem(),
            'preco'         => $this->getPreco(),
            'eh_vegano'     => $this->isEhVegano(),
            'eh_sem_gluten' => $this->isEhSemGluten(),
            'porcoes'       => $this->getPorcoes(),
            'categoria'     => $this->getCategoria()?->getIdCategoria()
        ];
    }

    public static function fromArray(array $data): self
    {
        $produto = new self();

        $produto
            ->setNome($data['nome'])
            ->setDescricao($data['descricao'])
            ->setPreco($data['preco'])
            ->setImagem($data['imagem'] ?? null)
            ->setEhVegano($data['eh_vegano'])
            ->setEhSemGluten($data['eh_sem_gluten'])
            ->setPorcoes($data['porcoes'])
            ->setCategoria((new Categoria())->setIdCategoria($data['categoria']))
        ;

        return $produto;
    }
}
