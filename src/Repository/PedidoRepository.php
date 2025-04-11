<?php

namespace App\Repository;

use App\Entity\Pedido;
use App\Service\DatabaseService;
use App\Repository\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Pedido>
 */
class PedidoRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry, DatabaseService $databaseService)
    {
        parent::__construct($registry, Pedido::class, $databaseService);
    }

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
        $sql = "
            SELECT
                p1.id_pedido,
                p1.comanda,
                p1.observacao,
                p1.data_pedido,
                p1.status_pedido,
                p1.id_produto,
                p2.nome,
                p2.descricao,
                p2.preco,
                p2.eh_vegano,
                p2.eh_sem_gluten,
                p2.imagem
            FROM pedido p1
                LEFT JOIN produto p2 ON pedido.id_produto = produto.id_produto
            WHERE comanda = :comanda
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
