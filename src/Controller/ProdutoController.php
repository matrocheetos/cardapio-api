<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProdutoRepository;
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
                        new OA\Property(property: "result", type: "array", items: new OA\Items(
                            type: "object",
                            properties: [
                                new OA\Property(property: "ID_PRODUTO", type: "integer"),
                                new OA\Property(property: "NOME", type: "string"),
                                new OA\Property(property: "DESCRICAO", type: "string"),
                                new OA\Property(property: "IMAGEM", type: "string"),
                                new OA\Property(property: "PRECO", type: "number", format: "float"),
                                new OA\Property(property: "EH_VEGANO", type: "bool"),
                                new OA\Property(property: "EH_SEM_GLUTEN", type: "bool"),
                                new OA\Property(property: "PORCOES", type: "integer"),
                                new OA\Property(property: "CATEGORIA", type: "integer"),
                            ]
                        ))
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

    #[Route('/produtos', name: 'produto_cria', methods: ['POST'])]
    public function cria(Request $request, ProdutoRepository $produtoRepository): JsonResponse
    {
        $result = $produtoRepository->cria($request);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }

    #[Route('/categoria', name: 'categoria_lista', methods: ['GET'])]
    public function listaCategoria(ProdutoRepository $produtoRepository)
    {
        $result = $produtoRepository->listaCategoria();

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }
}