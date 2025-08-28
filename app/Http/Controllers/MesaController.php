<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Repositories\MesaRepository;
use App\Http\Resources\MesaResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class MesaController extends Controller
{
    public function lista(): JsonResponse
    {
        try {
            $mesa = MesaResource::collection(Mesa::all());
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar mesa: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        return response()->json([
            'msg'    => null,
            'result' => $mesa,
            'error'  => false
        ], 200);
    }

    public function listaId(int $comanda): JsonResponse
    {
        try {
            $mesa = new MesaResource(Mesa::findOrFail($comanda));
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar mesa: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        return response()->json([
            'msg'    => null,
            'result' => $mesa,
            'error'  => false
        ], 200);
    }

    public function listaNroMesa(int $nro_mesa): JsonResponse
    {
        try {
            $mesa = MesaResource::collection(
                Mesa::where('nro_mesa', $nro_mesa)->get()
            );
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar mesa: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        return response()->json([
            'msg'    => null,
            'result' => $mesa,
            'error'  => false
        ], 200);
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
