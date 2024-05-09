<?php

namespace App\Controller;

use App\Entity\AdditionalInformation;
use App\Form\AdditionalInformationType;
use App\Repository\AdditionalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/additional/information')]
class AdditionalInformationController extends AbstractController
{
    #[Route('/', name: 'app_additional_information_index', methods: ['GET'])]
    public function index(AdditionalInformationRepository $additionalInformationRepository): Response
    {
        return $this->render('additional_information/index.html.twig', [
            'additional_informations' => $additionalInformationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_additional_information_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $additionalInformation = new AdditionalInformation();
        $form = $this->createForm(AdditionalInformationType::class, $additionalInformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($additionalInformation);
            $entityManager->flush();

            return $this->redirectToRoute('app_additional_information_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('additional_information/new.html.twig', [
            'additional_information' => $additionalInformation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_additional_information_show', methods: ['GET'])]
    public function show(AdditionalInformation $additionalInformation): Response
    {
        return $this->render('additional_information/show.html.twig', [
            'additional_information' => $additionalInformation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_additional_information_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AdditionalInformation $additionalInformation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdditionalInformationType::class, $additionalInformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_additional_information_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('additional_information/edit.html.twig', [
            'additional_information' => $additionalInformation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_additional_information_delete', methods: ['POST'])]
    public function delete(Request $request, AdditionalInformation $additionalInformation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$additionalInformation->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($additionalInformation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_additional_information_index', [], Response::HTTP_SEE_OTHER);
    }
}
