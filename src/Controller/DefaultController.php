<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    #[Route('/', name: 'index')]
    public function index(): JsonResponse
    {
        return new JsonResponse(['asdf' => 2]);
    }
}
