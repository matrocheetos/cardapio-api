<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
#[ORM\Table(name: 'PRODUTO')]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_produto = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $descricao = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagem = null;

    #[ORM\Column]
    private ?float $preco = null;

    #[ORM\Column]
    private ?bool $eh_vegano = null;

    #[ORM\Column]
    private ?bool $eh_sem_gluten = null;

    #[ORM\Column]
    private ?int $porcoes = null;

    #[ORM\Column]
    private ?int $categoria = null;


}
