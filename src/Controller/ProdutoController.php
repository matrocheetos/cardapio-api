<?php

namespace App\Controller;

use Nelmio\ApiDocBundle\Attribute\Model;
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
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/produtos/{id}', name: 'produto_lista_id', methods: ['GET'])]
    public function listaId(int $id, ProdutoRepository $produtoRepository): JsonResponse
    {
        $result = $produtoRepository->listaId($id);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/produtos/cria', name: 'produto_cria', methods: ['POST'])]
    public function cria(Request $request, ProdutoRepository $produtoRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $produto = Produto::fromArray($data);

        $result = $produtoRepository->cria($produto);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/produtos/edita/{id}', name: 'produto_edita', methods: ['PUT'])]
    public function edita(Request $request, ProdutoRepository $produtoRepository, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $produto = Produto::fromArray($data, $id);

        $result = $produtoRepository->edita($produto);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/produtos/deleta/{id}', name: 'produto_deleta', methods: ['DELETE'])]
    public function deleta(ProdutoRepository $produtoRepository, int $id): JsonResponse
    {
        $produto = new Produto();
        $produto->setIdProduto($id);

        $result = $produtoRepository->deleta($produto);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }
}