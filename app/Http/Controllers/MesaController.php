<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\MesaRepository;
use App\Models\Mesa;

final class MesaController extends Controller
{
    public function lista(MesaRepository $mesaRepository): JsonResponse
    {
        $result = $mesaRepository->lista();

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function listaId(MesaRepository $mesaRepository, int $comanda): JsonResponse
    {
        $result = $mesaRepository->listaId($comanda);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function listaNroMesa(MesaRepository $mesaRepository, int $nro_mesa): JsonResponse
    {
        $result = $mesaRepository->listaNroMesa($nro_mesa);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function cria(Request $request, MesaRepository $mesaRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $produto = Mesa::fromArray($data);

        $result = $mesaRepository->cria($produto);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function edita(Request $request, MesaRepository $mesaRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $mesa = Mesa::fromArray($data);

        $result = $mesaRepository->edita($mesa);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function deleta(MesaRepository $mesaRepository, int $id): JsonResponse
    {
        $mesa = new Mesa();
        $mesa->setComanda($id);

        $result = $mesaRepository->deleta($mesa);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }
}
