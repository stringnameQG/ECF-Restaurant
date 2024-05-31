<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Service\Mailer;
use App\Repository\BookingRepository;
use App\Repository\DayRepository;
use App\Repository\NumberOfPlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(
        Request $request, 
        EntityManagerInterface $entityManager,
        Mailer $mailer,
        DayRepository $dayRepository, 
        NumberOfPlaceRepository $numberOfPlaceRepository,
        BookingRepository $bookingRepository,
    ): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            
            $day = $form->get('date')->getData();
            $jour = $day->format("d");
            $mois = $day->format("m");
            $annee = $day->format("Y");

            $day = date('D', mktime(0, 0, 0, $mois, $jour, $annee));

            $dayInFrench = match($day){
                "Mon" => 'Lundi',
                "Tue" => 'Mardi',
                "Wed" => 'Mercredi',
                "Thu" => 'Jeudi',
                "Fri" => 'Vendredi',
                "Sat" => 'Samedi',
                "Sun" => 'Dimanche',
                default => 'error',
            };

            $schedulesList = $dayRepository->findSchedules($dayInFrench);
            $SCHEDUELESARRAY = ["openAM", "closeAM", "openPM", "closePM"];
            $schedulesConvert = [];
        
            for($i = 0; $i < 4; $i++){
                $SCHEDULES = $schedulesList[0][$SCHEDUELESARRAY[$i]]->format("H:i");
                $schedulesConvert[$SCHEDUELESARRAY[$i]] = $SCHEDULES;
            }
            
            $hoursOpen = explode(":", $schedulesConvert["openAM"]);
            $hoursOpenAM = $hoursOpen[0];
            $minuteOpenAM = $hoursOpen[1];
            
            $hoursClose = explode(":", $schedulesConvert["closeAM"]);
            $hoursCloseAM = $hoursClose[0];
            $minuteCloseAM = $hoursClose[1];
        
            $testArrayAM = [];

            $coeficientAugmentiation = 15;
            $AmCoef = 0;

            $hoursAdd = $schedulesList[0]["openAM"];
            do {
                array_push($testArrayAM, $hoursAdd->format("H:i"));
                date_modify($hoursAdd, '+' . $coeficientAugmentiation . ' minute');

                $AmCoef++;
            } while(mktime($hoursOpenAM, $minuteOpenAM + ($AmCoef * $coeficientAugmentiation), 0, 0, 0, 0) < mktime($hoursCloseAM-1, $minuteCloseAM, 0, 0, 0, 0));
            array_push($testArrayAM, $hoursAdd->format("H:i"));

            
            $hoursOpen = explode(":", $schedulesConvert["openPM"]);
            $hoursOpenPM = $hoursOpen[0];
            $minuteOpenPM = $hoursOpen[1];
            
            $hoursClose = explode(":", $schedulesConvert["closePM"]);
            $hoursClosePM = $hoursClose[0];
            $minuteClosePM = $hoursClose[1];
        
            $testArrayPM = [];
            $PmCoef = 0;

            $hoursAdd = $schedulesList[0]["openPM"];
            do {
                array_push($testArrayPM, $hoursAdd->format("H:i"));
                date_modify($hoursAdd, '+' . $coeficientAugmentiation . ' minute');

                $PmCoef++;
            } while(mktime($hoursOpenPM, $minuteOpenPM + ($PmCoef * $coeficientAugmentiation), 0, 0, 0, 0) < mktime($hoursClosePM-1, $minuteClosePM, 0, 0, 0, 0));
            array_push($testArrayPM, $hoursAdd->format("H:i"));


            $inArray = false;
            $amOrpm = "AM";
            if(in_array($form->get('hours')->getData(), $testArrayAM)){
                $inArray = true;
                $amOrpm = "AM";
            } else if(in_array($form->get('hours')->getData(), $testArrayPM)) {
                $inArray = true;
                $amOrpm = "PM";
            }

            $schedulesOpen = $schedulesList[0]["open" . $amOrpm]->format("H:i");
            $schedulesClose = $schedulesList[0]["close" . $amOrpm]->format("H:i");

            $dayOpenNumber = $bookingRepository->findBookingIfFull($schedulesOpen, $schedulesClose);
            $ReservedPlace = $numberOfPlaceRepository->findNumberOfPlace();
            $canReserve = true;
            
            if($dayOpenNumber[0]["1"] > $ReservedPlace[0]["numberOfPlace"]){
                $canReserve = false;
            }

            if($inArray && $canReserve){

                $date = $form->get('date')->getData();
                $date = $date->format("Y/m/d");
                
                $hours = $form->get('hours')->getData();

                $completDate = $date . " " . $hours;
                
                $booking->setDate(new \DateTime($completDate));

                $entityManager->persist($booking);
                $entityManager->flush();

                if(!is_null($user = $this->getUser())){

                    $emailAdresse = $this->getUser()->getUserIdentifier();
                    $numberOfGuests = $form->get('numberOfGuests')->getData();
                    $resevationName = $form->get('name')->getData();
                    $dateReservation = $form->get('date')->getData()->format('Y-m-d H:i');

                    $mailer->ConfirmBooking($emailAdresse, $numberOfGuests, $resevationName, $dateReservation);
                }

                return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        
        $user = $this->getUser();
        return $this->render('reservation/index.html.twig', [
            'booking' => $booking,
            'form' => $form,
            'currentUser' => $user,
        ]);
    }

    #[Route('/AlldayIfOpen')]
    public function RequeteDQLfindAllDayIfOpen(DayRepository $dayRepository)
    {
        $allDayOpen = $dayRepository->findAllDayIfOpen();

        $response = new Response();
        $response->setContent(json_encode($allDayOpen));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
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
    
    #[Route('/dayFullSchedules')]
    public function DQLRequestDayIsFull(BookingRepository $bookingRepository)
    {
        $schedulesOpen = $_GET['open'];
        $schedulesClose = $_GET['close'];
        $numberOfPlace = $_GET['numberOfPlace'];

        $dayOpenNumber = $bookingRepository->findBookingIfFull($schedulesOpen, $schedulesClose);

        $canReserve = true;
        
        if($dayOpenNumber[0]["1"] > $numberOfPlace){
            $canReserve = false;
        }

        $response = new Response();
        $response->setContent(json_encode($canReserve));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function RequeteDQLDaySchedulesINT(string $day, DayRepository $dayRepository)
    {
        return $dayRepository->findSchedules($day);
    }
    
    #[Route('/NumberOfPlace')]
    public function DQLRequestNumberOfPlace(NumberOfPlaceRepository $numberOfPlaceRepository)
    {
        $numberOfPlace = $numberOfPlaceRepository->findNumberOfPlace();

        $response = new Response();
        $response->setContent(json_encode($numberOfPlace));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
