<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\ProdutoCriaRequest;
use App\Http\Requests\ProdutoEditaRequest;
use App\Http\Resources\ProdutoResource;
use Illuminate\Http\JsonResponse;

final class ProdutoController extends ApiController
{
    /**
     * Retorna todos os produtos
     */
    public function lista(): JsonResponse
    {
        try {
            $produto = ProdutoResource::collection(Produto::all());
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar categoria: '.$e->getMessage());
        }

        return $this->success(null, $produto);
    }

    /**
     * Retorna um produto pelo ID
     */
    public function listaId(int $id): JsonResponse
    {
        try {
            $produto = new ProdutoResource(Produto::findOrFail($id));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Produto não encontrado');
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar produto: '.$e->getMessage());
        }

        return $this->success(null, $produto);
    }

    /**
     * Cria um novo produto
     */
    public function cria(ProdutoCriaRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $produto = Produto::create($data);
        } catch (\Exception $e) {
            return $this->error('Erro ao criar produto: '.$e->getMessage());
        }

        return $this->success(null, $produto);
    }

    /**
     * Edita um produto
     */
    public function edita(ProdutoEditaRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $produto = Produto::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Produto não encontrado');
        }

        $produto->fill($data);

        if ($produto->isDirty()) {
            $produto->save();
        }

        return $this->success(null, $produto);
    }

    /**
     * Deleta um produto
     */
    public function deleta(int $id): JsonResponse
    {
        try {
            $produto = Produto::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Produto não encontrado');
        }

        $produto->delete();

        return $this->success(null, $produto);
    }
}