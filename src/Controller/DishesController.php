<?php

namespace App\Controller;

use App\Entity\Dishes;
use App\Form\DishesType;
use App\Repository\DishesRepository;
use App\Repository\PictureDishesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping\Id;
use App\Service\PictureService;

#[Route('/dishes')]
class DishesController extends AbstractController
{
    #[Route('/', name: 'app_dishes_index', methods: ['GET'])]
    public function index(DishesRepository $dishesRepository): Response
    {
        return $this->render('dishes/index.html.twig', [
            'dishes' => $dishesRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_dishes_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager
    ): Response
    {
        $dish = new Dishes();
        $form = $this->createForm(DishesType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dish);
            $entityManager->flush();

            return $this->redirectToRoute('app_dishes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dishes/new.html.twig', [
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dishes_show', methods: ['GET'])]
    public function show(Dishes $dish): Response
    {
        return $this->render('dishes/show.html.twig', [
            'dish' => $dish,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dishes_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Dishes $dish, 
        EntityManagerInterface $entityManager
        ): Response
    {
        $form = $this->createForm(DishesType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dishes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dishes/edit.html.twig', [
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dishes_delete', methods: ['POST'])]
    public function delete(
        Request $request, 
        Dishes $dish, 
        EntityManagerInterface $entityManager,
        PictureDishesRepository $pictureDishesRepository,
        PictureService $pictureService
    ): Response
    {
        if($this->isCsrfTokenValid('delete'.$dish->getId(), $request->getPayload()->get('_token'))) {
            
            $dishId = $pictureDishesRepository->findPictureName($dish->getId());

            var_dump($dishId);

            foreach($dishId as &$value){
                var_dump($value);
                $pictureService->deleteImageCloudinary($value["name"]);
            }
            
            $entityManager->remove($dish);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dishes_index', [], Response::HTTP_SEE_OTHER);
    }
}
