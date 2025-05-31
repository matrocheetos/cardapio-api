<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\CategoriaRepository;
use App\Models\Categoria;

final class CategoriaController extends Controller
{
    public function lista(CategoriaRepository $categoriaRepository): JsonResponse
    {
        $result = $categoriaRepository->lista();

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function listaId(CategoriaRepository $categoriaRepository, int $id): JsonResponse
    {
        $result = $categoriaRepository->listaId($id);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
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
