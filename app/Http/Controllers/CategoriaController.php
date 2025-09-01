<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\CategoriaCriaRequest;
use App\Http\Requests\CategoriaEditaRequest;
use App\Http\Resources\CategoriaResource;
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

    /**
     * Cria uma nova categoria
     */
    public function cria(CategoriaCriaRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $categoria = Categoria::create($data);
        } catch (\Exception $e) {
            return $this->error('Erro ao criar categoria: '.$e->getMessage());
        }

        return $this->success(null, $categoria);
    }

    /**
     * Edita uma categoria
     */
    public function edita(CategoriaEditaRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $categoria = Categoria::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Categoria não encontrada');
        }

        $categoria->fill($data);

        if ($categoria->isDirty()) {
            $categoria->save();
        }

        return $this->success(null, $categoria);
    }

    /**
     * Deleta uma categoria
     */
    public function deleta(int $id): JsonResponse
    {
        try {
            $categoria = Categoria::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Categoria não encontrada');
        }

        $categoria->delete();

        return $this->success('Categoria deletada com sucesso', null);
    }
}
