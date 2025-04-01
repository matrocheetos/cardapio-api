<?php

namespace App\Controller;

use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProdutoRepository;
use App\Entity\Produto;
use OpenApi\Attributes as OA;

class ProdutoController extends AbstractController
{
    #[Route('/produtos', name: 'produto_lista', methods: ['GET'])]
    #[OA\Get(
        path: "/api/cardapio/produtos",
        summary: "Lista todos os produtos",
        tags: ["Produtos"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de produtos retornada com sucesso",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "msg", type: "string"),
                        new OA\Property(
                            property: "result",
                            type: "array",
                            items: new OA\Items(ref: new Model(type: Produto::class))
                        )
                    ]
                )
            ),
            new OA\Response(response: 400, description: "Erro ao listar produtos")
        ]
    )]
    public function lista(ProdutoRepository $produtoRepository): JsonResponse
    {
        $result = $produtoRepository->lista();

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }

    #[Route('/produtos/{id}', name: 'produto_lista_id', methods: ['GET'])]
    #[OA\Get(
        path: "/api/cardapio/produtos/{id}",
        summary: "Lista um produto por ID",
        tags: ["Produtos"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Detalhes do produto retornados com sucesso",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "msg", type: "string"),
                        new OA\Property(
                            property: "result",
                            type: "array",
                            items: new OA\Items(ref: new Model(type: Produto::class))
                        )
                    ]
                )
            ),
            new OA\Response(response: 400, description: "Erro ao retornar dados do produto")
        ]
    )]
    public function listaId(int $id, ProdutoRepository $produtoRepository): JsonResponse
    {
        $result = $produtoRepository->listaId($id);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }

    #[Route('/produtos', name: 'produto_cria', methods: ['POST'])]
    #[OA\Post(
        summary: "Cria um novo produto",
        tags: ["Produtos"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: "object",
                properties: [
                    new OA\Property(ref: new Model(type: Produto::class))
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Produto criado com sucesso",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "msg", type: "string", example: "Produto criado com sucesso"),
                        new OA\Property(property: "result", type: "object", ref: "#/components/schemas/Produto")
                    ]
                )
            ),
            new OA\Response(response: 400, description: "Erro ao criar produto"),
        ]
    )]
    public function cria(Request $request, ProdutoRepository $produtoRepository): JsonResponse
    {
        $result = $produtoRepository->cria($request);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }
}