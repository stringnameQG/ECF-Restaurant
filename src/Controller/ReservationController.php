<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DayRepository;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    
    #[Route('/dayIsOpen')]
    public function RequeteDQLDayIsOpen(DayRepository $dayRepository)
    {
        $day = $_GET['dayInFrench'];

        $dayOpenNumber = $dayRepository->findDayIfOpen($day);

        $response = new Response();
        $response->setContent(json_encode($dayOpenNumber));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    #[Route('/daySchedules')]
    public function RequeteDQLDaySchedules(DayRepository $dayRepository)
    {
        $day = $_GET['dayInFrench'];

        $dayOpenNumber = $dayRepository->findSchedules($day);

        $response = new Response();
        $response->setContent(json_encode($dayOpenNumber));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
