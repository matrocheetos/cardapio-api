<?php

namespace App\Repository;

use App\Entity\Produto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produto>
 */
class ProdutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produto::class);
    }

    public function lista(): array
    {
        $produto = new Produto();

        try {
            $produtos = $produto->getProdutos();
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar produtos: '.$e->getMessage(),
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => null,
            'result' => $produtos
        ];
    }

    public function cria($request)
    {
        $data = json_decode($request->getContent(), true);

        $nome        = $data['nome'];
        $descricao   = $data['descricao'];
        $imagem      = $data['imagem'] ?? null; 
        $preco       = $data['preco'];
        $ehVegano    = $data['ehVegano'];
        $ehSemGluten = $data['ehSemGluten'];
        $porcoes     = $data['porcoes'];
        $categoria   = $data['categoria'];
        
        $produto = new Produto();

        try {
            $result = $produto->setProduto($nome, $descricao, $imagem, $preco, $ehVegano, $ehSemGluten, $porcoes, $categoria);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao cadastrar produto: '.$e->getMessage(),
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Produto cadastrado com sucesso.',
            'result' => $result
        ];
    }
}
