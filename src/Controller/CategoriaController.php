<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoriaRepository;
use OpenApi\Attributes as OA;

final class CategoriaController extends AbstractController
{
    #[Route('/categorias', name: 'categoria_lista', methods: ['GET'])]

    public function lista(CategoriaRepository $categoriaRepository): JsonResponse
    {
        $result = $categoriaRepository->lista();

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }

    #[Route('/categorias/{id}', name: 'categoria_lista_id', methods: ['GET'])]
    public function listaId(CategoriaRepository $categoriaRepository, int $id): JsonResponse
    {
        $result = $categoriaRepository->listaId($id);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }
}
