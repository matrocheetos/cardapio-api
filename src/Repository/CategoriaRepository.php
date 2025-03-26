<?php

namespace App\Repository;

use App\Entity\Categoria;
use App\Service\DatabaseService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoria>
 */
class CategoriaRepository extends ServiceEntityRepository
{
    private \SQLite3 $db;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
        $this->db = DatabaseService::getInstance();
    }

    public function lista(): array
    {
        $categoria = new Categoria();

        $sql = "
            SELECT
                ID_CATEGORIA,
                DESCRICAO
            FROM CATEGORIA;
        ";

        try {
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $result = DatabaseService::fetch($result);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar categorias: '.$e->getMessage(),
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
        $categoria = new Categoria();

        $sql = "
            SELECT
                ID_CATEGORIA,
                DESCRICAO
            FROM CATEGORIA
            WHERE ID_CATEGORIA = :id
        ";

        $params = [
            ':id' => $id
        ];

        try {
            $stmt = $this->db->prepare($sql);
            $stmt = DatabaseService::bind($stmt, $params);
            $result = $stmt->execute();
            $result = DatabaseService::fetch($result);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao listar categorias: '.$e->getMessage(),
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => null,
            'result' => $result
        ];
    }
}
