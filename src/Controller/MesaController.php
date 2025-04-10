<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MesaRepository;
use App\Entity\Mesa;

final class MesaController extends AbstractController
{
    #[Route('/mesa', name: 'mesa_lista', methods: ['GET'])]
    public function lista(MesaRepository $mesaRepository): JsonResponse
    {
        $result = $mesaRepository->lista();

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/mesa/{comanda}', name: 'mesa_lista_comanda', methods: ['GET'])]
    public function listaId(MesaRepository $mesaRepository, int $comanda): JsonResponse
    {
        $result = $mesaRepository->listaId($comanda);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/mesa?nro_mesa={nro_mesa}', name: 'mesa_lista_nromesa', methods: ['GET'])]
    public function listaNroMesa(MesaRepository $mesaRepository, int $nro_mesa): JsonResponse
    {
        $result = $mesaRepository->listaNroMesa($nro_mesa);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/mesa/cria', name: 'mesa_cria', methods: ['POST'])]
    public function cria(Request $request, MesaRepository $mesaRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $produto = Mesa::fromArray($data);

        $result = $mesaRepository->cria($produto);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/mesa/edita', name: 'mesa_edita', methods: ['PUT'])]
    public function edita(Request $request, MesaRepository $mesaRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $mesa = Mesa::fromArray($data);

        $result = $mesaRepository->edita($mesa);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }

    #[Route('/mesa/deleta/{id}', name: 'mesa_deleta', methods: ['DELETE'])]
    public function deleta(MesaRepository $mesaRepository, int $id): JsonResponse
    {
        $mesa = new Mesa();
        $mesa->setComanda($id);

        $result = $mesaRepository->deleta($mesa);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result'],
            'error'  => $result['error']
        ], $result['status']);
    }
}
