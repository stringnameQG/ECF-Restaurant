<?php
namespace App\Controller;

use App\Repository\DayRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CGVController extends AbstractController
{
  #[Route('/cgv', name: 'app_cgv', methods: ['GET', 'POST'])]
  public function CGV(DayRepository $dayRepository) : Response
  {
    return $this->render('cgv/CGV.html.twig', [
      'listDay' => $dayRepository->findAll(),
    ]);
  }
}
