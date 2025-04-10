<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoriaRepository;
use App\Entity\Categoria;

final class CategoriaController extends AbstractController
{
    #[Route('/categorias', name: 'categoria_lista', methods: ['GET'])]

    public function lista(CategoriaRepository $categoriaRepository): JsonResponse
    {
        $result = $categoriaRepository->lista();

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/categorias/{id}', name: 'categoria_lista_id', methods: ['GET'])]
    public function listaId(CategoriaRepository $categoriaRepository, int $id): JsonResponse
    {
        $result = $categoriaRepository->listaId($id);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/categorias/cria', name: 'categoria_cria', methods: ['POST'])]
    public function cria(Request $request, CategoriaRepository $categoriaRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $categoria = Categoria::fromArray($data);

        $result = $categoriaRepository->cria($categoria);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/categorias/edita/{id}', name: 'categoria_edita', methods: ['PUT'])]
    public function edita(Request $request, CategoriaRepository $categoriaRepository, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $categoria = Categoria::fromArray($data, $id);

        $result = $categoriaRepository->edita($categoria);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/categorias/deleta/{id}', name: 'categoria_deleta', methods: ['DELETE'])]
    public function deleta(CategoriaRepository $categoriaRepository, int $id): JsonResponse
    {
        $categoria = new Categoria();
        $categoria->setIdCategoria($id);

        $result = $categoriaRepository->deleta($categoria);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }
}
