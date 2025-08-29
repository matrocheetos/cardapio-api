<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Resources\PedidoResource;
use App\Http\Resources\PedidoProdutoResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class PedidoController extends ApiController
{
    /**
     * Retorna todos os pedidos
     */
    public function lista(): JsonResponse
    {
        try {
            $pedido = PedidoResource::collection(Pedido::all());
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar pedidos: '.$e->getMessage());
        }

        return $this->success(null, $pedido);
    }

    /**
     * Retorna um pedido pelo ID
     */
    public function listaId(int $id): JsonResponse
    {
        try {
            $pedido = new PedidoResource(Pedido::findOrFail($id));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->notFound('Pedido não encontrado');
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar pedido: '.$e->getMessage());
        }

        return $this->success(null, $pedido);
    }

    /**
     * Retorna todos os pedidos e produtos de uma comanda
     */
    public function listaComanda(int $comanda): JsonResponse
    {
        try {
            $pedidoProdutoCollection = PedidoProdutoResource::collection(
                Pedido::where('comanda', $comanda)->get()
            );
        } catch (\Exception $e) {
            return $this->error('Erro ao buscar comanda: '.$e->getMessage());
        }

        if ($pedidoProdutoCollection->isEmpty()) {
            return $this->notFound('Comanda não encontrada');
        }

        $comanda = [
            'comanda'     => $comanda,
            'preco_total' => $pedidoProdutoCollection->sum('produto.preco'),
            'pedidos'     => $pedidoProdutoCollection
        ];

        return $this->success(null, $comanda);
    }

    /**
     * Cria um novo pedido
     */
    public function cria(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        try {
            $pedido = Pedido::create([
                'comanda'       => $data->comanda,
                'id_produto'    => $data->id_produto,
                'observacao'    => $data->observacao ?? null
            ]);
        } catch (\Exception $e) {
            return $this->error('Erro ao criar pedido: '.$e->getMessage());
        }

        return $this->success(null, $pedido);
    }

    /**
     * Edita um pedido
     */
    public function edita(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        try {
            $pedido = Pedido::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Pedido não encontrado');
        }

        $pedido->fill($data);

        if ($pedido->isDirty()) {
            $pedido->save();
        }

        return $this->success(null, $pedido);
    }

    /**
     * Deleta um pedido
     */
    public function deleta(int $id): JsonResponse
    {
        try {
            $pedido = Pedido::findOrFail($id);
        } catch (\Exception $e) {
            return $this->notFound('Pedido não encontrado');
        }

        $pedido->delete();

        return $this->success('Pedido deletado com sucesso', null);
    }
}
