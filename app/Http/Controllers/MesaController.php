<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Repositories\MesaRepository;
use App\Http\Resources\MesaResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class MesaController extends ApiController
{
    /**
     * Retorna todas as mesas
     */
    public function lista(): JsonResponse
    {
        try {
            $mesa = MesaResource::collection(Mesa::all());
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar mesa: '.$e->getMessage());
        }

        return $this->success(null, $mesa);
    }

    /**
     * Retorna uma mesa pelo número da comanda
     */
    public function listaId(int $comanda): JsonResponse
    {
        try {
            $mesa = new MesaResource(Mesa::findOrFail($comanda));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Mesa não encontrada');
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar mesa: '.$e->getMessage());
        }

        return $this->success(null, $mesa);
    }

    /**
     * Retorna as comandas pelo número da mesa
     */
    public function listaNroMesa(int $nro_mesa): JsonResponse
    {
        try {
            $mesa = MesaResource::collection(
                Mesa::where('nro_mesa', '=', $nro_mesa)->get()
            );
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar mesa '.$nro_mesa.': '.$e->getMessage());
        }

        if ($mesa->isEmpty()) {
            return $this->notFound('Mesa não encontrada');
        }

        return $this->success(null, $mesa);
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
