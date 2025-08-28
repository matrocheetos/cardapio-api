<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use App\Http\Resources\ProdutoResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProdutoController extends ApiController
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

    public function cria(Request $request, ProdutoRepository $produtoRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $produto = Produto::fromArray($data);

        $result = $produtoRepository->cria($produto);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function edita(Request $request, ProdutoRepository $produtoRepository, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $produto = Produto::fromArray($data, $id);

        $result = $produtoRepository->edita($produto);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function deleta(ProdutoRepository $produtoRepository, int $id): JsonResponse
    {
        $produto = new Produto();
        $produto->setIdProduto($id);

        $result = $produtoRepository->deleta($produto);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }
}