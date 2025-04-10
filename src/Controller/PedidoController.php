<?php

namespace App\Controller;

use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PedidoRepository;
use App\Entity\Pedido;
use OpenApi\Attributes as OA;

final class PedidoController extends AbstractController
{
    #[Route('/pedido', name: 'pedido_lista', methods: ['GET'])]
    public function lista(PedidoRepository $pedidoRepository): JsonResponse
    {
        $result = $pedidoRepository->lista();

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }

    #[Route('/pedido/{id}', name: 'pedido_lista_id', methods: ['GET'])]
    public function listaId(PedidoRepository $pedidoRepository, int $id): JsonResponse
    {
        $result = $pedidoRepository->listaId($id);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }


    #[Route('/pedido/cria', name: 'pedido_cria', methods: ['POST'])]
    public function cria(Request $request, PedidoRepository $pedidoRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['pedido'])) {
            return $this->json([
                'msg'    => 'Pedido não informado',
                'result' => null,
                'status' => 'error'
            ], 400);
        }
        
        foreach ($data['pedido'] as $p) {
            $pedido = Pedido::fromArray($p);
            $result = $pedidoRepository->cria($pedido);
            
            if($result['status'] === 400) {
                return $this->json([
                    'msg'    => $result['msg'],
                    'result' => null,
                    'status' => 'error'
                ], $result['status']);
            }
        }

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'status' => 'success'
        ], $result['status']);
    }

    #[Route('/pedido/edita/{id}', name: 'pedido_edita', methods: ['PUT'])]
    public function edita(Request $request, PedidoRepository $pedidoRepository, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $pedido = new Pedido();
        $pedido->fromArray($data, $id);

        $result = $pedidoRepository->edita($pedido);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }

    #[Route('/pedido/deleta/{id}', name: 'pedido_deleta', methods: ['DELETE'])]
    public function deleta(PedidoRepository $pedidoRepository, int $id): JsonResponse
    {
        $pedido = new Pedido();
        $pedido->setIdPedido($id);

        $result = $pedidoRepository->deleta($pedido);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }
}
