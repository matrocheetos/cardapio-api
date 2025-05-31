<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Produto;

class ProdutoRepository
{
    public function lista(): array
    {
        $sql = "
            SELECT
                id_produto,
                id_categoria,
                nome,
                descricao,
                imagem,
                preco,
                eh_vegano,
                eh_sem_gluten,
                porcoes
            FROM produto;
        ";

        try {
            $result = $this->db->consulta($sql);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar produtos: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ];
        }

        return [
            'status' => 200,
            'msg'    => null,
            'result' => $result,
            'error'  => false
        ];
    }

    public function listaId(int $id): array
    {
        $sql = "
            SELECT
                id_produto,
                id_categoria,
                nome,
                descricao,
                imagem,
                preco,
                eh_vegano,
                eh_sem_gluten,
                porcoes
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
                'result' => null,
                'error'  => true
            ];
        }

        return [
            'status' => 200,
            'msg'    => null,
            'result' => $result,
            'error'  => false
        ];
    }

    public function cria(Produto $produto): array
    {
        $sql = "
            INSERT INTO produto (id_categoria, nome, descricao, imagem, preco, eh_vegano, eh_sem_gluten, porcoes)
            VALUES (:id_categoria, :nome, :descricao, :imagem, :preco, :eh_vegano, :eh_sem_gluten, :porcoes)
        ";

        $params = [
            ':id_categoria'  => $produto->getCategoria()->getIdCategoria(),
            ':nome'          => $produto->getNome(),
            ':descricao'     => $produto->getDescricao(),
            ':imagem'        => $produto->getImagem(),
            ':preco'         => $produto->getPreco(),
            ':eh_vegano'     => $produto->isEhVegano(),
            ':eh_sem_gluten' => $produto->isEhSemGluten(),
            ':porcoes'       => $produto->getPorcoes()
        ];

        try {
            $result = $this->db->insere($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao cadastrar produto: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ];
        }

        $produto->setIdProduto($result['id']);

        return [
            'status' => 200,
            'msg'    => 'Produto cadastrado com sucesso!',
            'result' => $produto->toArray(),
            'error'  => false
        ];
    }

    public function edita(Produto $produto): array
    {
        $sql = "
            UPDATE produto
            SET id_categoria = :id_categoria,
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
            ':porcoes'       => $produto->getPorcoes(),
            ':id_produto'    => $produto->getIdProduto()
        ];

        try {
            $result = $this->db->atualiza($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao editar produto: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ];
        }

        if(!$result) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao editar produto.',
                'result' => null,
                'error'  => true
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Produto editado com sucesso!',
            'result' => $produto->toArray(),
            'error'  => false
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
                'result' => null,
                'error'  => true
            ];
        }

        if(!$result) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao deletar produto.',
                'result' => null,
                'error'  => true
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Produto deletado com sucesso!',
            'result' => null,
            'error'  => false
        ];
    }
}
