<?php

namespace App\Controller;

use App\Repository\DayRepository;
use App\Repository\MenuRepository;
use App\Repository\FormulaRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarteController extends AbstractController
{
    #[Route('/carte', name: 'app_carte')]
    public function Carte(
        MenuRepository $menuRepository, 
        FormulaRepository $formulaRepository,
        DayRepository $dayRepository
        ): Response
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("active", 1));
        $menu = $menuRepository->matching($criteria);

        return $this->render('carte/index.html.twig', [
            'formula' => $formulaRepository->findAll(),
            'menu' => $menu,
            'listDay' => $dayRepository->findAll(),
        ]);
    }
}
