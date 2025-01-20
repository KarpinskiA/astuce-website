<?php

namespace App\Controller;

use App\Entity\Tip;
use App\Form\TipType;
use App\Service\TipService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/new', name: 'app_astuce_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, TipService $tipService): Response
    {
        $tip = new Tip();
        $form = $this->createForm(TipType::class, $tip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Prepare the tip for persistence (ex. setting slug, status, etc.)
            $tipService->prepareTipForPersistence($tip);
            $entityManager->persist($tip);
            $entityManager->flush();

            return $this->redirectToRoute('app_astuce');
        }

        return $this->render('astuce/new.html.twig', [
            'form' => $form,
        ]);
    }
}
