<?php

namespace App\Repository;

use App\Entity\Mesa;
use App\Service\DatabaseService;
use App\Repository\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Mesa>
 */
class MesaRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry, DatabaseService $databaseService)
    {
        parent::__construct($registry, Mesa::class, $databaseService);
    }

    public function lista(): array
    {
        $sql = "
            SELECT
                comanda,
                nro_mesa,
                status_pagamento
            FROM mesa
            ORDER BY comanda ASC
        ";

        try {
            $result = $this->db->consulta($sql);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar comandas: '.$e->getMessage(),
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => null,
            'result' => $result
        ];
    }

    public function listaId(int $comanda): array
    {
        $sql = "
            SELECT
                comanda,
                nro_mesa,
                status_pagamento
            FROM mesa
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
                'msg'    => 'Erro ao listar comanda: '.$e->getMessage(),
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => null,
            'result' => $result
        ];
    }

    public function listaNroMesa(int $nroMesa): array
    {
        $sql = "
            SELECT
                comanda,
                nro_mesa,
                status_pagamento
            FROM mesa
            WHERE nro_mesa = :nro_mesa
        ";

        $params = [
            ':nro_mesa' => $nroMesa
        ];

        try {
            $result = $this->db->consulta($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar mesa: '.$e->getMessage(),
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => null,
            'result' => $result
        ];
    }

    public function cria(Mesa $mesa): array
    {
        $sql = "
            INSERT INTO mesa (nro_mesa, status_pagamento)
            VALUES (:nro_mesa, :status_pagamento)
        ";

        $params = [
            ':nro_mesa'         => $mesa->getNroMesa(),
            ':status_pagamento' => $mesa->getStatusPagamento()
        ];

        try {
            $result = $this->db->insere($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao gerar comanda: '.$e->getMessage(),
                'result' => null
            ];
        }

        $mesa->setComanda($result['id']);

        return [
            'status' => 200,
            'msg'    => 'Comanda gerada com sucesso.',
            'result' => $mesa->toArray()
        ];
    }

    public function edita(Mesa $mesa): array
    {
        $sql = "
            UPDATE mesa
            SET nro_mesa = :nro_mesa,
                status_pagamento = :status_pagamento
            WHERE comanda = :comanda
        ";

        $params = [
            ':nro_mesa'         => $mesa->getNroMesa(),
            ':status_pagamento' => $mesa->getStatusPagamento(),
            ':comanda'          => $mesa->getComanda()
        ];

        try {
            $result = $this->db->atualiza($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao editar comanda: '.$e->getMessage(),
                'result' => null
            ];
        }

        if(!$result) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao editar comanda',
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Comanda editada com sucesso',
            'result' => $mesa->toArray()
        ];
    }

    public function deleta(Mesa $mesa): array
    {
        $sql = "
            DELETE FROM mesa
            WHERE comanda = :comanda
        ";

        $params = [
            ':comanda' => $mesa->getComanda()
        ];

        try {
            $result = $this->db->deleta($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao deletar comanda: '.$e->getMessage(),
                'result' => null
            ];
        }

        if(!$result) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao deletar comanda',
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Comanda deletada com sucesso',
            'result' => null
        ];
    }
}
