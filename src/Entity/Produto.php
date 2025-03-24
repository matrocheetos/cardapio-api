<?php

namespace App\Entity;

use App\Service\DatabaseService;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
#[ORM\Table(name: 'PRODUTO')]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idProduto = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $descricao = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagem = null;

    #[ORM\Column]
    private ?float $preco = null;

    #[ORM\Column]
    private ?bool $ehVegano = null;

    #[ORM\Column]
    private ?bool $ehSemGluten = null;

    #[ORM\Column]
    private ?int $porcoes = null;

    #[ORM\Column]
    private ?int $categoria = null;


    public function getProdutos(): array
    {
        $sql = "
            SELECT * FROM PRODUTO;
        ";
        
        $db = DatabaseService::getInstance();
        $stmt = $db->prepare($sql);
        $result = $stmt->execute();
        
        return DatabaseService::fetch($result);
    }

    public function setProduto(string $nome, string $descricao, string $imagem = null, float $preco, bool $ehVegano, bool $ehSemGluten, int $porcoes, int $categoria)
    {
        $sql = "
            INSERT INTO PRODUTO (NOME, DESCRICAO, IMAGEM, PRECO, EH_VEGANO, EH_SEM_GLUTEN, PORCOES, CATEGORIA)
            VALUES (:nome, :descricao, :imagem, :preco, :eh_vegano, :eh_sem_gluten, :porcoes, :categoria);
        ";

        $params = [
            ':nome'          => $nome,
            ':descricao'     => $descricao,
            ':imagem'        => $imagem,
            ':preco'         => $preco,
            ':eh_vegano'     => $ehVegano,
            ':eh_sem_gluten' => $ehSemGluten,
            ':porcoes'       => $porcoes,
            ':categoria'     => $categoria
        ];

        $db   = DatabaseService::getInstance();
        $stmt = $db->prepare($sql);
        $stmt = DatabaseService::bind($stmt, $params);
        
        $result = $stmt->execute();
        $result->finalize();

        return $result->fetchArray();
    }

}
