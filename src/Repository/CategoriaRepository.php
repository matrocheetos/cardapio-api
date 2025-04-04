<?php

namespace App\Repository;

use App\Entity\Categoria;
use App\Service\DatabaseService;
use App\Repository\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Categoria>
 */
class CategoriaRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry, DatabaseService $databaseService)
    {
        parent::__construct($registry, Categoria::class, $databaseService);
    }

    public function lista(): array
    {
        $categoria = new Categoria();

        $sql = "
            SELECT
                id_categoria,
                descricao
            FROM categoria
            ORDER BY descricao ASC;
        ";

        try {
            $result = $this->db->consulta($sql);
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
                id_categoria,
                descricao
            FROM categoria
            WHERE id_categoria = ?
        ";
        
        $params = [
            1 => $id
        ];

        try {
            $result = $this->db->consulta($sql, $params);
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
