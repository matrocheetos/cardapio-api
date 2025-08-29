<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
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

    /**
     * Cria uma nova comanda para uma mesa
     */
    public function cria(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        try {
            $mesa = Mesa::create([
                'nro_mesa' => $data->nro_mesa
            ]);
        } catch (\Exception $e) {
            return $this->error('Erro ao criar mesa: '.$e->getMessage());
        }

        return $this->success(null, $mesa);
    }

    /**
     * Edita uma comanda
     */
    public function edita(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        try {
            $mesa = Mesa::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Mesa não encontrada');
        }

        $mesa->fill($data);

        if ($mesa->isDirty()) {
            $mesa->save();
        }

        return $this->success(null, $mesa);
    }

    /**
     * Deleta uma comanda
     */
    public function deleta(int $id): JsonResponse
    {
        try {
            $mesa = Mesa::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Mesa não encontrada');
        }

        $mesa->delete();

        return $this->success(null, $mesa);
    }
}
