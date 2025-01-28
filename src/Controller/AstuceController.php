<?php

namespace App\Controller;

use App\Entity\Tip;
use App\Form\TipType;
use App\Repository\TipRepository;
use App\Service\TipService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AstuceController extends AbstractController
{
    #[Route('/', name: 'app_astuce', methods: ['GET'])]
    public function index(TipRepository $tipRepository): Response
    {
        return $this->render('astuce/index.html.twig', [
            'tips' => $tipRepository->findAll(),
        ]);
    }

    #[Route('/astuce/{id}', name: 'app_astuce_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id, TipRepository $tipRepository): Response
    {
        $result = $tipRepository->findDetailOfOneTip($id);

        if (!$result) {
            throw $this->createNotFoundException('Cette astuce n\'existe pas.');
        }

        return $this->render('astuce/show.html.twig', [
            'tip' => $result['tip'],
            'ingredientQuantities' => $result['ingredientQuantities'],
        ]);
    }

    #[Route('/astuce/new', name: 'app_astuce_new', methods: ['GET', 'POST'])]
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

    #[Route('/astuce/{id}/edit', name: 'app_astuce_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Tip $tip, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TipType::class, $tip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tip->setUpdatedAt(new DateTimeImmutable());
            $entityManager->flush();

            return $this->redirectToRoute('app_astuce', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('astuce/edit.html.twig', [
            'tip' => $tip,
            'form' => $form,
        ]);
    }

    #[Route('/astuce/{id}', name: 'app_astuce_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Tip $tip, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tip->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_astuce', [], Response::HTTP_SEE_OTHER);
    }
}
