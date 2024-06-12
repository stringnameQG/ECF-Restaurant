<?php
namespace App\Controller;

use App\Repository\DayRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MentionsLegaleController extends AbstractController
{
  #[Route('/mentionslegale', name: 'app_mentionslegale', methods: ['GET', 'POST'])]
  public function MentionsLegale(DayRepository $dayRepository) : Response
  {
    return $this->render('mentionLegale/MentionsLegale.html.twig', [
      'listDay' => $dayRepository->findAll(),
    ]);
  }
}

