<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class UserController extends AbstractController
{
    #[Route('/profil/me', 'app_profil_me', methods: ['GET'])]
    public function me(): Response
    {
        return $this->render('front/user/me.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/profil/{id}', name: 'app_profil_show', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function show(User $user): Response
    {
        return $this->render('front/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil/{id}/edit', name: 'app_profil_edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profil_me', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
