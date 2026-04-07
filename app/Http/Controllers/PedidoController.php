<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Requests\PedidoCriaRequest;
use App\Http\Requests\PedidoEditaRequest;
use App\Http\Resources\PedidoResource;
use App\Http\Resources\PedidoProdutoResource;
use Illuminate\Http\JsonResponse;

final class PedidoController extends ApiController
{
    /**
     * Retorna todos os pedidos
     * @unauthenticated
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
     * @unauthenticated
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
     * @unauthenticated
     */
    public function listaComanda(int $comanda): JsonResponse
    {
        try {
            $pedidoProdutoCollection = PedidoProdutoResource::collection(
                Pedido::where('comanda', '=', $comanda)->get()
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
     * @unauthenticated
     */
    public function cria(PedidoCriaRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $pedido = Pedido::create($data);
        } catch (\Exception $e) {
            return $this->error('Erro ao criar pedido: '.$e->getMessage());
        }

        return $this->success(null, $pedido);
    }

    /**
     * Edita um pedido
     */
    public function edita(PedidoEditaRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

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
