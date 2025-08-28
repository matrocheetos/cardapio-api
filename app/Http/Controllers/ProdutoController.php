<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use App\Http\Resources\ProdutoResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    public function lista(): JsonResponse
    {
        try {
            $produto = ProdutoResource::collection(Produto::all());
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar categoria: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        return response()->json([
            'msg'    => null,
            'result' => $produto,
            'error'  => false
        ], 200);
    }

    public function listaId(int $id): JsonResponse
    {
        try {
            $produto = new ProdutoResource(Produto::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar categoria: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        return response()->json([
            'msg'    => null,
            'result' => $produto,
            'error'  => false
        ], 200);
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