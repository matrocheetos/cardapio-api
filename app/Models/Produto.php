<?php

namespace App\Models;

use App\Repository\ProdutoRepository;

class Produto
{
    private ?int $idProduto = null;

    private string $nome;

    private string $descricao;

    private ?string $imagem = null;

    private float $preco;

    private bool $ehVegano = false;

    private bool $ehSemGluten = false;

    private int $porcoes;

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

    public function isEhVegano(): int
    {
        return $this->ehVegano ? 1 : 0;
    }

    public function setEhVegano(bool $ehVegano): static
    {
        $this->ehVegano = $ehVegano;

        return $this;
    }

    public function isEhSemGluten(): int
    {
        return $this->ehSemGluten ? 1 : 0;
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
            'id_categoria'  => $this->getCategoria()?->getIdCategoria(),
            'nome'          => $this->getNome(),
            'descricao'     => $this->getDescricao(),
            'imagem'        => $this->getImagem(),
            'preco'         => $this->getPreco(),
            'eh_vegano'     => $this->isEhVegano(),
            'eh_sem_gluten' => $this->isEhSemGluten(),
            'porcoes'       => $this->getPorcoes()
        ];
    }

    public static function fromArray(array $data, int $id = null): self
    {
        if (!isset($data['nome'], $data['descricao'], $data['preco'], $data['eh_vegano'], $data['eh_sem_gluten'], $data['porcoes'], $data['id_categoria'])) {
            throw new \InvalidArgumentException('Dados incompletos ou inválidos para o produto.');
        }
        
        $produto = new self();
        $produto
            ->setNome($data['nome'])
            ->setDescricao($data['descricao'])
            ->setPreco($data['preco'])
            ->setImagem($data['imagem'] ?? null)
            ->setEhVegano($data['eh_vegano'])
            ->setEhSemGluten($data['eh_sem_gluten'])
            ->setPorcoes($data['porcoes'])
            ->setCategoria((new Categoria())->setIdCategoria($data['id_categoria']))
        ;

        if (isset($id)) {
            $produto->setIdProduto($id);
        }

        return $produto;
    }
}
