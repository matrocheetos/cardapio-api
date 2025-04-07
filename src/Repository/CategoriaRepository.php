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
        $sql = "
            SELECT
                id_categoria,
                descricao
            FROM categoria
            WHERE id_categoria = :id_categoria
        ";
        
        $params = [
            ':id_categoria' => $id
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

    public function cria(Categoria $categoria): array
    {
        $sql = "
            INSERT INTO categoria (descricao)
            VALUES (:descricao)
        ";

        $params = [
            ':descricao' => $categoria->getDescricao()
        ];

        try {
            $result = $this->db->insere($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao cadastrar categoria: '.$e->getMessage(),
                'result' => null
            ];
        }

        $categoria->setIdCategoria($result['id']);

        return [
            'status' => 200,
            'msg'    => 'Categoria cadastrada com sucesso',
            'result' => $categoria->toArray()
        ];
    }

    public function edita(Categoria $categoria): array
    {
        $sql = "
            UPDATE categoria
            SET descricao = :descricao
            WHERE id_categoria = :id_categoria
        ";

        $params = [
            ':descricao'    => $categoria->getDescricao(),
            ':id_categoria' => $categoria->getIdCategoria()
        ];

        try {
            $result = $this->db->atualiza($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao editar categoria: '.$e->getMessage(),
                'result' => null
            ];
        }

        if(!$result) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao editar categoria',
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Categoria editada com sucesso',
            'result' => $categoria->toArray()
        ];
    }

    public function deleta(Categoria $categoria): array
    {
        $sql = "
            DELETE FROM categoria
            WHERE id_categoria = :id_categoria
        ";

        $params = [
            ':id_categoria' => $categoria->getIdCategoria()
        ];

        try {
            $result = $this->db->deleta($sql, $params);
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao deletar categoria: '.$e->getMessage(),
                'result' => null
            ];
        }

        if(!$result) {
            return [
                'status' => 400,
                'msg'    => 'Erro ao deletar categoria',
                'result' => null
            ];
        }

        return [
            'status' => 200,
            'msg'    => 'Categoria deletada com sucesso',
            'result' => null
        ];
    }
}
