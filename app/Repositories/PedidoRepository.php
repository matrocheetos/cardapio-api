<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Pedido;

class PedidoRepository
{
    public function lista(): array
    {
        $sql = "
            SELECT
                id_pedido,
                comanda,
                id_produto,
                observacao,
                data_pedido,
                status_pedido
            FROM pedido
            WHERE status_pedido IN ('PREPARANDO', 'PRONTO')
            ORDER BY data_pedido ASC
        ";

        try {
            $result = $this->db->consulta($sql);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar pedidos: '.$e->getMessage(),
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
                id_pedido,
                comanda,
                id_produto,
                observacao,
                data_pedido,
                status_pedido
            FROM pedido
            WHERE id_pedido = :id_pedido
        ";

        $params = [
            ':id_pedido' => $id
        ];

        try {
            $result = $this->db->consulta($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar pedido: '.$e->getMessage(),
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

    public function listaComanda(int $comanda):array
    {
//        $sql = "
//            SELECT
//                p1.id_pedido,
//                p1.comanda,
//                p1.observacao,
//                p1.data_pedido,
//                p1.status_pedido,
//                p1.id_produto,
//                p2.nome,
//                p2.descricao,
//                p2.preco,
//                p2.eh_vegano,
//                p2.eh_sem_gluten,
//                p2.imagem
//            FROM pedido p1
//                LEFT JOIN produto p2 ON p1.id_produto = p2.id_produto
//            WHERE comanda = :comanda
//        ";

        $sql = "
            SELECT
                c.comanda AS comanda,
                c.total AS total,
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id_pedido', p.latest_id,
                        'data_pedido', p.latest_date,
                        'status_pedido', p.latest_status,
                        'produto', JSON_OBJECT(
                            'id', p.id_produto,
                            'name', p.nome,
                            'preco', p.preco,
                            'observacao', p.observacao,
                            'quantidade', p.quantidade,
                            'isGlutenFree', p.eh_sem_gluten,
                            'isVegan', p.eh_vegano,
                            'description', p.descricao,
                            'image', p.imagem
                        )
                    )
                ) AS pedidos
            FROM (
                -- Get comanda and total information
                SELECT 
                    comanda,
                    SUM(prod_total) AS total
                FROM (
                    SELECT 
                        p1.comanda,
                        p1.id_produto,
                        COUNT(p1.id_produto) * p2.preco AS prod_total
                    FROM pedido p1
                    JOIN produto p2 ON p1.id_produto = p2.id_produto
                    WHERE p1.comanda = :comanda
                    GROUP BY p1.comanda, p1.id_produto, p2.preco
                ) AS subtotals
                GROUP BY comanda
            ) AS c
            CROSS JOIN (
                -- Get product information with quantities
                SELECT
                    MAX(p1.id_pedido) AS latest_id,
                    MAX(p1.data_pedido) AS latest_date,
                    MAX(p1.status_pedido) AS latest_status,
                    p1.id_produto,
                    COUNT(*) AS quantidade,
                    MAX(p1.observacao) AS observacao,
                    p2.nome,
                    p2.descricao,
                    p2.preco,
                    p2.eh_vegano,
                    p2.eh_sem_gluten,
                    p2.imagem
                FROM pedido p1
                JOIN produto p2 ON p1.id_produto = p2.id_produto
                WHERE p1.comanda = :comanda
                GROUP BY p1.id_produto, p2.nome, p2.descricao, p2.preco, p2.eh_vegano, p2.eh_sem_gluten, p2.imagem
            ) AS p
            GROUP BY c.comanda, c.total
        ";

        $params = [
            ':comanda' => $comanda
        ];

        try {
            $result = $this->db->consulta($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar pedidos: '.$e->getMessage(),
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

    public function cria(Pedido $pedido): array
    {
        $sql = "
            INSERT INTO pedido (comanda, id_produto, observacao, data_pedido, status_pedido)
            VALUES (:comanda, :id_produto, :observacao, :data_pedido, :status_pedido)
        ";

        $params = [
            ':comanda'       => $pedido->getMesa()->getComanda(),
            ':id_produto'    => $pedido->getProduto()->getIdProduto(),
            ':observacao'    => $pedido->getObservacao(),
            ':data_pedido'   => $pedido->getDataPedido(),
            ':status_pedido' => $pedido->getStatusPedido()
        ];

        try {
            $result = $this->db->insere($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao cadastrar pedido: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ];
        }

        $pedido->setIdPedido($result['id']);

        return [
            'status' => 200,
            'msg'    => 'Pedido cadastrado com sucesso!',
            'result' => null,
            'error'  => false
        ];
    }

    public function edita(Pedido $pedido): array
    {
        $sql = "
            UPDATE pedido
            SET comanda = :comanda,
                id_produto = :id_produto,
                observacao = :observacao,
                status_pedido = :status_pedido
            WHERE id_pedido = :id_pedido
        ";

        $params = [
            ':comanda'       => $pedido->getMesa()->getComanda(),
            ':id_produto'    => $pedido->getProduto()->getIdProduto(),
            ':observacao'    => $pedido->getObservacao(),
            ':status_pedido' => $pedido->getStatusPedido(),
            ':id_pedido'     => $pedido->getIdPedido()
        ];

        try {
            $this->db->atualiza($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao editar pedido: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Pedido atualizado com sucesso!',
            'result' => $pedido->toArray(),
            'error'  => false
        ];
    }

    public function deleta(Pedido $pedido): array
    {
        $sql = "
            DELETE FROM pedido
            WHERE id_pedido = :id_pedido
        ";

        $params = [
            ':id_pedido' => $pedido->getIdPedido()
        ];

        try {
            $this->db->deleta($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao deletar pedido: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Pedido deletado com sucesso!',
            'result' => null,
            'error'  => false
        ];
    }
}
