<?php

namespace App\Controller;

use App\Entity\PictureDishes;
use App\Form\PictureDishesType;
use App\Repository\PictureDishesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/picture/dishes')]
class PictureDishesController extends AbstractController
{
    #[Route('/', name: 'app_picture_dishes_index', methods: ['GET'])]
    public function index(PictureDishesRepository $pictureDishesRepository): Response
    {
        return $this->render('picture_dishes/index.html.twig', [
            'picture_dishes' => $pictureDishesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_picture_dishes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pictureDish = new PictureDishes();
        $form = $this->createForm(PictureDishesType::class, $pictureDish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pictureDish);
            $entityManager->flush();

            return $this->redirectToRoute('app_picture_dishes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture_dishes/new.html.twig', [
            'picture_dish' => $pictureDish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_picture_dishes_show', methods: ['GET'])]
    public function show(PictureDishes $pictureDish): Response
    {
        return $this->render('picture_dishes/show.html.twig', [
            'picture_dish' => $pictureDish,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_picture_dishes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PictureDishes $pictureDish, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PictureDishesType::class, $pictureDish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_picture_dishes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture_dishes/edit.html.twig', [
            'picture_dish' => $pictureDish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_picture_dishes_delete', methods: ['POST'])]
    public function delete(Request $request, PictureDishes $pictureDish, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pictureDish->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($pictureDish);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_picture_dishes_index', [], Response::HTTP_SEE_OTHER);
    }
}
