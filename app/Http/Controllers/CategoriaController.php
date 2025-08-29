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

    /**
     * Cria uma nova categoria
     */
    public function cria(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        try {
            $categoria = Categoria::create([
                'descricao' => $data->descricao
            ]);
        } catch (\Exception $e) {
            return $this->error('Erro ao criar categoria: '.$e->getMessage());
        }

        return $this->success(null, $categoria);
    }

    /**
     * Edita uma categoria
     */
    public function edita(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
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
