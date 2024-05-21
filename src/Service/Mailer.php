<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Exception;

class Mailer
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function ErrorSendMail($error): void
    {
        echo('Une erreur est apparue: ' . $error . '\n' . 'Impossible d\'envoyer le mail');
    }

    public function ConfirmInscription(string $emailAdresse, string $password): void
    {
        try{
            $email = (new Email())
            ->from('QuaiAntique@gmail.com')
            ->to($emailAdresse)
            ->subject('Restaurant QuaiAntique')
            ->text('Vous venez de créer un compte au Restaurant QuaiAntique. Votre mot de passe est ' . $password);

            $this->mailer->send($email);
        } catch(Exception $e) {
            $this->ErrorSendMail($e);
        }
    }
    
    public function ConfirmModification(string $emailAdresse, string $password): void
    {
        try{
            $email = (new Email())
            ->from('QuaiAntique@gmail.com')
            ->to($emailAdresse)
            ->subject('Restaurant QuaiAntique')
            ->text('Vous venez de modifer votre compte au Restaurant QuaiAntique. Votre mot de passe est ' . $password);

            $this->mailer->send($email);
        } catch(Exception $e) {
            $this->ErrorSendMail($e);
        }
    }
    
    public function ConfirmBooking(string $emailAdresse, int $numberOfGuests, string $resevationName, string $dateReservation): void
    {
        try{
            $email = (new Email())
            ->from('QuaiAntique@gmail.com')
            ->to($emailAdresse)
            ->subject('Restaurant QuaiAntique')
            ->text('Vous venez de réserver une table pour ' 
            .  $numberOfGuests
            . ' personne au nom de ' . $resevationName
            . ' pour le ' . $dateReservation);

            $this->mailer->send($email);
        } catch(Exception $e) {
            $this->ErrorSendMail($e);
        }
    }
}