<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\Mailer;
use App\Repository\UserRepository;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/booking')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'app_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,
        Mailer $mailer
    ): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date = $form->get('date')->getData();
            $booking->setDate($date);

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

        $user = $this->getUser();
        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
            'currentUser' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
    }
}
