<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\ProdutoRepository;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function lista(ProdutoRepository $produtoRepository): JsonResponse
    {
        $result = $produtoRepository->lista();

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function listaId(int $id, ProdutoRepository $produtoRepository): JsonResponse
    {
        $result = $produtoRepository->listaId($id);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
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