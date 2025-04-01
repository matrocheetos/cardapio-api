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

    public function lista()
    {

        $sql = "
            SELECT
                ID_PEDIDO,
                COMANDA,
                ID_PRODUTO,
                OBSERVACAO,
                DATA_PEDIDO,
                STATUS_PEDIDO
            FROM PEDIDO
        ";

        try {
            $result = $this->db->consulta($sql);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar pedidos: '.$e->getMessage(),
                'result' => null
            ];
        }
        
        // foreach($result as $p) {
        //     $pedido = new Pedido(
        //         $p['COMANDA'],
        //         $p['ID_PRODUTO'],
        //         $p['OBSERVACAO']);
        //     $pedido->setIdPedido($p['ID_PEDIDO']);
        //     $pedido->setDataPedido($p['DATA_PEDIDO']);
        //     $pedido->setStatusPedido($p['STATUS_PEDIDO']);
            
        //     $resultPedidos[] = $pedido;
        //     echo '<pre>'; print_r($pedido); exit;
        // }

        return [
            'status' => 200,
            'msg'    => null,
            'result' => $result
        ];
    }

    public function cria(Pedido $pedido): array
    {
        $sql = "
            INSERT INTO PEDIDO (COMANDA, ID_PRODUTO, OBSERVACAO)
            VALUES (:comanda, :id_produto, :observacao)
        ";

        $params = [
            ':comanda'       => $pedido->getComanda(),
            ':id_produto'    => $pedido->getIdProduto(),
            ':observacao'    => $pedido->getObservacao()
        ];

        try {
            $result = $this->db->insere($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao cadastrar pedido: '.$e->getMessage()
            ];
        }

        return [
            'status' => 201,
            'msg'    => 'Pedido cadastrado com sucesso'
        ];
    }
}
