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

    public function cria($request): array
    {
        $data = json_decode($request->getContent(), true);

        $mesa = new Mesa();

        $sql = "
            INSERT INTO MESA (NRO_MESA)
            VALUES (:nro_mesa)
        ";

        $params = [
            ':nro_mesa' => $data['nro_mesa']
        ];

        try {
            $resultMesa = $this->db->insere($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao cadastrar produto: '.$e->getMessage(),
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => null,
            'result' => $resultMesa
        ];
    }
}
