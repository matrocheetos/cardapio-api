<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Resources\ProdutoResource;
use Illuminate\Http\Request;
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
    public function cria(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        try {
            $produto = Produto::create([
                'id_categoria' => $data->id_categoria,
                'nome'         => $data->nome,
                'descricao'    => $data->descricao,
                'imagem'       => $data->imagem,
                'preco'        => (float) $data->preco,
                'eh_vegano'    => (bool) $data->eh_vegano,
                'eh_sem_gluten'=> (bool) $data->eh_sem_gluten,
                'em_estoque'   => true,
                'porcoes'      => (int) $data->porcoes
            ]);
        } catch (\Exception $e) {
            return $this->error('Erro ao criar produto: '.$e->getMessage());
        }

        return $this->success(null, $produto);
    }

    /**
     * Edita um produto
     */
    public function edita(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
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