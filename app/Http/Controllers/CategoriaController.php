<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use App\Http\Resources\CategoriaResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class CategoriaController extends Controller
{
    public function lista(): JsonResponse
    {
        try {
            $categoria = CategoriaResource::collection(Categoria::all());
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar categoria: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        return response()->json([
            'msg'    => null,
            'result' => $categoria,
            'error'  => false
        ], 200);
    }

    public function listaId(int $id): JsonResponse
    {
        try {
            $categoria = new CategoriaResource(Categoria::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar categoria: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        return response()->json([
            'msg'    => null,
            'result' => $categoria,
            'error'  => false
        ], 200);
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
