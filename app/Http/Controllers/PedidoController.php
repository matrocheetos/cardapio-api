<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoProdutoResource;
use App\Models\Pedido;
use App\Repositories\PedidoRepository;
use App\Http\Resources\PedidoResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class PedidoController extends Controller
{
    public function lista(): JsonResponse
    {
        try {
            $pedido = PedidoResource::collection(Pedido::all());
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar pedidos: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        return response()->json([
            'msg'    => null,
            'result' => $pedido,
            'error'  => false
        ], 200);
    }

    public function listaId(int $id): JsonResponse
    {
        try {
            $pedido = new PedidoResource(Pedido::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar pedido: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        return response()->json([
            'msg'    => null,
            'result' => $pedido,
            'error'  => false
        ], 200);
    }

    public function listaComanda(int $comanda): JsonResponse
    {
        try {
            $pedidoProdutoCollection = PedidoProdutoResource::collection(
                Pedido::where('comanda', $comanda)->get()
            );
        } catch (\Exception $e) {
            return response()->json([
                'msg'    => 'Erro ao buscar produtos do pedido: '.$e->getMessage(),
                'result' => null,
                'error'  => true
            ], 400);
        }

        $comanda = [
            'comanda'     => $comanda,
            'preco_total' => $pedidoProdutoCollection->sum('produto.preco'),
            'pedidos'     => $pedidoProdutoCollection
        ];

        return response()->json([
            'msg'    => null,
            'result' => $comanda,
            'error'  => false
        ], 200);
    }

    public function cria(Request $request, PedidoRepository $pedidoRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['pedido'])) {
            return response()->json([
                'msg'    => 'Pedido não informado',
                'result' => null,
                'error' => true
            ], 400);
        }
        foreach ($data['pedido'] as $p) {
            $pedido = Pedido::fromArray($p);
            $result = $pedidoRepository->cria($pedido);
            
            if($result['status'] === 400) {
                return response()->json([
                    'msg'    => $result['msg'],
                    'result' => $result['result'],
                    'error'  => $result['error']
                ], $result['status']);
            }
        }

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function edita(Request $request, PedidoRepository $pedidoRepository, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $pedido = new Pedido();
        $pedido->fromArray($data, $id);

        $result = $pedidoRepository->edita($pedido);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function deleta(PedidoRepository $pedidoRepository, int $id): JsonResponse
    {
        $pedido = new Pedido();
        $pedido->setIdPedido($id);

        $result = $pedidoRepository->deleta($pedido);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }
}
