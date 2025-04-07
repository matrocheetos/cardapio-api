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
    #[OA\Get(
        path: "/api/cardapio/pedido",
        summary: "Lista todos os pedidos",
        tags: ["Pedidos"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de pedidos retornada com sucesso",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "msg", type: "string"),
                        new OA\Property(
                            property: "result",
                            type: "array",
                            items: new OA\Items(ref: new Model(type: Pedido::class))
                        )
                    ]
                )
            ),
            new OA\Response(response: 400, description: "Erro ao listar pedidos")
        ]
    )]
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


    #[Route('/pedido', name: 'pedido_cria', methods: ['POST'])]
    #[OA\Post(
        path: "/api/cardapio/pedido",
        summary: "Registra novo pedido",
        tags: ["Pedidos"],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                type: "object",
                properties: [
                    new OA\Property(property: "comanda", type: "integer", example: 1, description: "Número da comanda associada ao pedido"),
                    new OA\Property(property: "id_produto", type: "integer", example: 3, description: "ID do produto solicitado"),
                    new OA\Property(property: "observacao", type: "string", example: "Sem cebola", description: "Observação opcional para o pedido")
                ],
                required: ["comanda", "id_produto"]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Pedido registrado com sucesso",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "msg", type: "string", example: "Pedido registrado com sucesso"),
                        new OA\Property(property: "status", type: "string", example: "success")
                    ]
                )
            ),
            new OA\Response(response: 400, description: "Erro ao criar produto"),
        ]
    )]
    public function cria(Request $request, PedidoRepository $pedidoRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data as $p) {
            $pedido = new Pedido();
            $pedido->fromArray($p);

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
}
