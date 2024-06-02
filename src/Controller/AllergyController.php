<?php

namespace App\Controller;

use App\Entity\Allergy;
use App\Form\AllergyType;
use App\Repository\AllergyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/allergy')]
class AllergyController extends AbstractController
{
    #[Route('/', name: 'app_allergy_index', methods: ['GET'])]
    public function index(AllergyRepository $allergyRepository): Response
    {
        return $this->render('allergy/index.html.twig', [
            'allergies' => $allergyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_allergy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $allergy = new Allergy();
        $form = $this->createForm(AllergyType::class, $allergy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($allergy);
            $entityManager->flush();

            return $this->redirectToRoute('app_allergy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('allergy/new.html.twig', [
            'allergy' => $allergy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_allergy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Allergy $allergy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AllergyType::class, $allergy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_allergy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('allergy/edit.html.twig', [
            'allergy' => $allergy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_allergy_delete', methods: ['POST'])]
    public function delete(Request $request, Allergy $allergy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$allergy->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($allergy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_allergy_index', [], Response::HTTP_SEE_OTHER);
    }
}
