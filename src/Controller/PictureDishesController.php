<?php

namespace App\Controller;

use App\Entity\PictureDishes;
use App\Form\PictureDishesType;
use App\Repository\PictureDishesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\PictureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,
        PictureService $pictureService
    ): Response
    {
        $pictureDish = new PictureDishes();
        $form = $this->createForm(PictureDishesType::class, $pictureDish);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $pictures = $form->get('pictures')->getData();
            $picturesTitle = $form->get('title')->getData();
            $picturesDishes = $form->get('dishes')->getData();

            foreach($pictures as $picture) {
                
                $fichier = $pictureService->add($picture);

                $img = new PictureDishes();
                $img->setTitle($picturesTitle);
                $img->setName($fichier);
                $img->setDishes($picturesDishes);

            }
            
            $entityManager->persist($img);
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
    public function edit(Request $request, 
    PictureDishes $pictureDish, 
    EntityManagerInterface $entityManager,
    PictureService $pictureService
    ): Response
    {
        $pictureDish = new PictureDishes();
        $form = $this->createForm(PictureDishesType::class, $pictureDish);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $pictures = $form->get('pictures')->getData();
            $picturesTitle = $form->get('title')->getData();
            $picturesDishes = $form->get('dishes')->getData();

            // On boucle sur les images 
            foreach($pictures as $picture) {
                
                $fichier = $pictureService->add($picture);

                $img = new PictureDishes();
                $img->setTitle($picturesTitle);
                $img->setName($fichier);
                $img->setDishes($picturesDishes);
            }

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
    
    #[Route('delete/{id}', name: 'app_picture_dishes_delete_image', methods: ['DELETE'])]
    public function deleteImage(
        PictureDishes $picture, 
        Request $request, 
        EntityManagerInterface $em,
        PictureService $pictureService
        ){
            
        $data = json_decode($request->getContent(), true);
        
        if($this->isCsrfTokenValid('delete'.$picture->getId(), $data['_token'])){

            $nom = $picture->getName();

            $pictureService->deleteImageCloudinary($nom);

            $em->remove($picture);
            $em->flush();

            return new JsonResponse(['success' => 1]);
            
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
