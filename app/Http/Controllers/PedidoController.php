<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\PedidoRepository;
use App\Models\Pedido;

final class PedidoController extends Controller
{
    public function lista(PedidoRepository $pedidoRepository): JsonResponse
    {
        $result = $pedidoRepository->lista();

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function listaId(PedidoRepository $pedidoRepository, int $id): JsonResponse
    {
        $result = $pedidoRepository->listaId($id);

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    public function listaComanda(PedidoRepository $pedidoRepository, int $comanda): JsonResponse
    {
        $result = $pedidoRepository->listaComanda($comanda);

//        foreach ($result['result'] as $pedido) {
//            $pedidos[] = Pedido::fromArray($pedido);
//        }

        // exemplo retorno
        // {
        //     comanda: number
        //     total: number
        //     pedidos: [
        //         {
        //             id_pedido: number
        //             data_pedido: string
        //             status_pedido
        //             produto: {
        //                 id: number,
        //                 name: string,
        //                 preco: number,
        //                 observacao: string,
        //                 quantidade: number,
        //                 isGlutenFree: boolean,
        //                 isVegan: boolean,
        //                 description: string,
        //                 image: Base64
        //             }
        //         },
        //         { ... }
        //     ]
        // }

        return response()->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
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
