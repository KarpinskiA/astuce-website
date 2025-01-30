<?php

namespace App\Controller\Front;

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
use Symfony\Component\Routing\Requirement\Requirement;

class TipController extends AbstractController
{
    #[Route('/tip/{id}', name: 'app_front_tip_show', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function show(int $id, TipRepository $tipRepository): Response
    {
        $result = $tipRepository->findDetailOfOneTip($id);

        if (!$result) {
            throw $this->createNotFoundException('Cette astuce n\'existe pas.');
        }

        return $this->render('front/tip/show.html.twig', [
            'tip' => $result['tip'],
            'ingredientQuantities' => $result['ingredientQuantities'],
        ]);
    }

    #[Route('/tip/new', name: 'app_front_tip_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TipService $tipService): Response
    {
        // Check if the user is authenticated
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $tip = new Tip();
        $form = $this->createForm(TipType::class, $tip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Get the current authenticated user
            $user = $this->getUser();

            // Prepare the tip for persistence (ex. setting slug, status, etc.)
            $tipService->prepareTipForPersistence($tip, $user);
            $entityManager->persist($tip);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('front/tip/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/tip/{id}/edit', name: 'app_front_tip_edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Request $request, Tip $tip, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TipType::class, $tip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tip->setUpdatedAt(new DateTimeImmutable());
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/tip/edit.html.twig', [
            'tip' => $tip,
            'form' => $form,
        ]);
    }

    #[Route('/tip/{id}', name: 'app_front_tip_delete', methods: ['POST'], requirements: ['id' => Requirement::DIGITS])]
    public function delete(Request $request, Tip $tip, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tip->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
