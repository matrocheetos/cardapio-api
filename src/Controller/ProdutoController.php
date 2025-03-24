<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProdutoRepository;
use App\Entity\Produto;

class ProdutoController extends AbstractController
{


    #[Route('/produtos', name: 'produto_lista', methods: ['GET'])]
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
}