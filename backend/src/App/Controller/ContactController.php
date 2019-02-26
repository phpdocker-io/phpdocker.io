<?php

namespace App\Controller;

use PHPDocker\Contact\DispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ContactController
{
    /**
     * @var DispatcherInterface
     */
    private $emailDispatcher;

    public function __construct(DispatcherInterface $emailDispatcher)
    {
        $this->emailDispatcher = $emailDispatcher;
    }

    public function process(Request $request): JsonResponse
    {
        return new JsonResponse(['ok']);
    }
}
