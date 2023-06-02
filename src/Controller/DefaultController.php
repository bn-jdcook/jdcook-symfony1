<?php

namespace App\Controller;

use App\Message\TestMessage;
use App\Service\MessageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{

    private MessageService $service;

    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    #[Route('/', name: 'index')]
    public function index(): JsonResponse
    {
        return new JsonResponse(['asdf' => 2]);
    }

    #[Route('/message/{name}', name: 'test_message')]
    public function testMessage(string $name): JsonResponse
    {
        $this->service->dispatch(new TestMessage($name));
        return new JsonResponse(['name' => $name]);
    }
}
