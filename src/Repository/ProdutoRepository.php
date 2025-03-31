<?php

namespace App\Repository;

use App\Entity\Produto;
use App\Service\DatabaseService;
use App\Repository\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Produto>
 */
class ProdutoRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry, DatabaseService $databaseService)
    {
        parent::__construct($registry, Produto::class, $databaseService);
    }

    public function lista(): array
    {
        $produto = new Produto();

        $sql = "
            SELECT
                NOME,
                DESCRICAO,
                IMAGEM,
                PRECO,
                EH_VEGANO,
                EH_SEM_GLUTEN,
                PORCOES,
                CATEGORIA
            FROM PRODUTO;
        ";

        try {
            $result = $this->db->consulta($sql);
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
            'result' => $result
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

        try {
            $result = $this->db->insere($sql, $params);
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
