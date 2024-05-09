<?php

namespace App\Controller;

use App\Entity\CateringService;
use App\Form\CateringServiceType;
use App\Repository\CateringServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/catering/service')]
class CateringServiceController extends AbstractController
{
    #[Route('/', name: 'app_catering_service_index', methods: ['GET'])]
    public function index(CateringServiceRepository $cateringServiceRepository): Response
    {
        return $this->render('catering_service/index.html.twig', [
            'catering_services' => $cateringServiceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_catering_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cateringService = new CateringService();
        $form = $this->createForm(CateringServiceType::class, $cateringService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cateringService);
            $entityManager->flush();

            return $this->redirectToRoute('app_catering_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('catering_service/new.html.twig', [
            'catering_service' => $cateringService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_catering_service_show', methods: ['GET'])]
    public function show(CateringService $cateringService): Response
    {
        return $this->render('catering_service/show.html.twig', [
            'catering_service' => $cateringService,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_catering_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CateringService $cateringService, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CateringServiceType::class, $cateringService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_catering_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('catering_service/edit.html.twig', [
            'catering_service' => $cateringService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_catering_service_delete', methods: ['POST'])]
    public function delete(Request $request, CateringService $cateringService, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cateringService->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($cateringService);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_catering_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
