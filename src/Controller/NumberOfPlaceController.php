<?php

namespace App\Controller;

use App\Entity\NumberOfPlace;
use App\Form\NumberOfPlaceType;
use App\Repository\NumberOfPlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/number/of/place')]
class NumberOfPlaceController extends AbstractController
{
    #[Route('/', name: 'app_number_of_place_index', methods: ['GET'])]
    public function index(NumberOfPlaceRepository $numberOfPlaceRepository): Response
    {
        return $this->render('number_of_place/index.html.twig', [
            'number_of_places' => $numberOfPlaceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_number_of_place_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $numberOfPlace = new NumberOfPlace();
        $form = $this->createForm(NumberOfPlaceType::class, $numberOfPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($numberOfPlace);
            $entityManager->flush();

            return $this->redirectToRoute('app_number_of_place_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('number_of_place/new.html.twig', [
            'number_of_place' => $numberOfPlace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_number_of_place_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NumberOfPlace $numberOfPlace, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NumberOfPlaceType::class, $numberOfPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_number_of_place_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('number_of_place/edit.html.twig', [
            'number_of_place' => $numberOfPlace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_number_of_place_delete', methods: ['POST'])]
    public function delete(Request $request, NumberOfPlace $numberOfPlace, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$numberOfPlace->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($numberOfPlace);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_number_of_place_index', [], Response::HTTP_SEE_OTHER);
    }
}
