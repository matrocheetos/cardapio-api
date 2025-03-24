<?php

namespace App\Controller;

use App\Service\DatabaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ProdutoController extends AbstractController
{
    #[Route('/produto/lista')]
    public function lista()
    {
        $db = DatabaseService::getInstance();
        $stmt = $db->query("SELECT * FROM PRODUTO;");
        $produtos = $stmt->fetchArray(SQLITE3_ASSOC);

        return $this->json($produtos);
    }
}