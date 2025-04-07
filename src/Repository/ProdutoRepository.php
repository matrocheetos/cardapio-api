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
        $sql = "
            SELECT
                id_produto,
                nome,
                descricao,
                imagem,
                preco,
                eh_vegano,
                eh_sem_gluten,
                porcoes,
                id_categoria
            FROM produto;
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

    public function listaId(int $id): array
    {
        $sql = "
            SELECT
                id_produto,
                nome,
                descricao,
                imagem,
                preco,
                eh_vegano,
                eh_sem_gluten,
                porcoes,
                id_categoria
            FROM produto
            WHERE id_produto = :id_produto;
        ";

        $params = [
            ':id_produto' => $id
        ];

        try {
            $result = $this->db->consulta($sql, $params);
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

    public function cria(Produto $produto): array
    {
        $sql = "
            INSERT INTO produto (id_categoria, nome, descricao, imagem, preco, eh_vegano, eh_sem_gluten, porcoes, )
            VALUES (:id_categoria, :nome, :descricao, :imagem, :preco, :eh_vegano, :eh_sem_gluten, :porcoes);
        ";

        $params = [
            ':nome'          => $produto->getNome(),
            ':descricao'     => $produto->getDescricao(),
            ':imagem'        => $produto->getImagem(),
            ':preco'         => $produto->getPreco(),
            ':eh_vegano'     => $produto->isEhVegano(),
            ':eh_sem_gluten' => $produto->isEhSemGluten(),
            ':porcoes'       => $produto->getPorcoes(),
            ':id_categoria'     => $produto->getCategoria()->getIdCategoria()
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

        $produto->setIdProduto($result['id']);

        return [
            'status' => 200,
            'msg'    => 'Produto cadastrado com sucesso!',
            'result' => $produto->toArray()
        ];
    }

    public function edita(Produto $produto): array
    {
        $sql = "
            UPDATE produto
            SET 
                id_categoria = :id_categoria,
                nome = :nome,
                descricao = :descricao,
                imagem = :imagem,
                preco = :preco,
                eh_vegano = :eh_vegano,
                eh_sem_gluten = :eh_sem_gluten,
                porcoes = :porcoes
            WHERE id_produto = :id_produto
        ";

        $params = [
            ':id_categoria'  => $produto->getCategoria()->getIdCategoria(),
            ':nome'          => $produto->getNome(),
            ':descricao'     => $produto->getDescricao(),
            ':imagem'        => $produto->getImagem(),
            ':preco'         => $produto->getPreco(),
            ':eh_vegano'     => $produto->isEhVegano(),
            ':eh_sem_gluten' => $produto->isEhSemGluten(),
            ':porcoes'       => $produto->getPreco(),
            ':id_produto'    => $produto->getIdProduto()
        ];

        try {
            $result = $this->db->atualiza($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao editar produto: '.$e->getMessage(),
                'result' => null
            ];
        }

        if(!$result) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao editar produto.',
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Produto editado com sucesso!',
            'result' => $produto->toArray()
        ];
    }

    public function deleta(Produto $produto): array
    {
        $sql = "
            DELETE FROM produto
            WHERE id_produto = :id_produto
        ";

        $params = [
            ':id_produto' => $produto->getIdProduto()
        ];

        try {
            $result = $this->db->deleta($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao deletar produto: '.$e->getMessage(),
                'result' => null
            ];
        }

        if(!$result) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao deletar produto.',
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Produto deletado com sucesso!',
            'result' => null
        ];
    }
}
