<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AstuceController extends AbstractController
{
    #[Route('/', name: 'app_astuce')]
    public function index(): Response
    {
        return $this->render('astuce/index.html.twig', [
            'controller_name' => 'AstuceController',
        ]);
    }
}
