<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index(): Response
    {
        return $this->json([
            'controller_name' => 'MessageController',
        ]);
    }
}