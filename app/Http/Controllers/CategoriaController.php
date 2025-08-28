<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use App\Http\Resources\CategoriaResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class CategoriaController extends ApiController
{
    /**
     * Retorna todas as categorias
     */
    public function lista(): JsonResponse
    {
        try {
            $categoria = CategoriaResource::collection(Categoria::all());
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar categoria: '.$e->getMessage());
        }

        return $this->success(null, $categoria);
    }

    /**
     * Retorna uma categoria pelo ID
     */
    public function listaId(int $id): JsonResponse
    {
        try {
            $categoria = new CategoriaResource(Categoria::findOrFail($id));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Categoria não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar categoria: '.$e->getMessage());
        }

        return $this->success(null, $categoria);
    }

    public function cria(Request $request, CategoriaRepository $categoriaRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $categoria = Categoria::fromArray($data);

        $result = $categoriaRepository->cria($categoria);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function edita(Request $request, CategoriaRepository $categoriaRepository, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $categoria = Categoria::fromArray($data, $id);

        $result = $categoriaRepository->edita($categoria);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function deleta(CategoriaRepository $categoriaRepository, int $id): JsonResponse
    {
        $categoria = new Categoria();
        $categoria->setIdCategoria($id);

        $result = $categoriaRepository->deleta($categoria);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }
}
