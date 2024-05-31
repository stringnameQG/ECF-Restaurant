<?php

namespace App\Controller;

use App\Repository\DayRepository;
use App\Repository\PictureDishesRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    #[Route('', name: 'app_accueil')]
    public function Accueil(PictureDishesRepository $pictureDishesRepository, DayRepository $dayRepository): Response
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("display", 1));
        $pictureDishes = $pictureDishesRepository->matching($criteria);

        return $this->render('home_page/index.html.twig', [
            'pictureDishes' => $pictureDishes,
            'pictureDishesTEST' => $pictureDishesRepository->findAll(),
            'listDay' => $dayRepository->findAll(),
        ]);
    }
}
