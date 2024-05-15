<?php

$adresseBdd = new PDO('mysql:host=localhost;dbname=restaurantarnaudmichant;charset=utf8', 'root', '');

$sql = 'SELECT date_open
FROM catering_service 
ORDER BY date_open
DESC LIMIT 1';

$recipesStatement = $adresseBdd->prepare($sql);
$recipesStatement->execute();
$derniereEnregistrement = $recipesStatement->fetchAll();

if(count($derniereEnregistrement) != 0){ echo 'if';
    CreationLimiteDateReservation($derniereEnregistrement);
} else { echo 'else';
    $dateDebut = date('Y-m-d', strtotime(date("Y-m-d"). ' + 1 days'));
    
    CreationLimiteDateReservation($dateDebut);
}


function CreationDateReservationJour($dateDebut, $derniereDate)
{   
    // $dateDebut = new DateTime($dateDebut);
    // $dateDebut = new DateTime($dateDebut);
    echo $dateDebut; echo ' ' . $derniereDate;
    $start = new DateTime('2009-01-01');
    $end = new DateTime('2009-02-09');

    foreach (new DatePeriod($dateDebut, new DateInterval('P1D'), $end) as $day) {
        echo $day->format('Y-m-d');
    }
}

function CreationLimiteDateReservation($dateDebut){
    $dureeAjoute = ' + 1 year';
    $dateAujourdhui = date("Y");
    $derniereDate = date('Y-m-d', strtotime($dureeAjoute, strtotime($dateAujourdhui) ));
    CreationDateReservationJour($dateDebut, $derniereDate);
}