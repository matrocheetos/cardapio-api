<?php

namespace App\Controller;

use App\Repository\MesaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class MesaController extends AbstractController
{
    #[Route('/mesa', name: 'mesa_lista')]
    public function lista(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MesaController.php',
        ]);
    }

    public function cria(Request $request, MesaRepository $mesaRepository): JsonResponse
    {
        $result = $mesaRepository->cria($request);

        return $this->json([
            'msg'    => $result['msg'],
            'result' => $result['result']
        ], $result['status']);
    }
}
