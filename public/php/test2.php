<?php
//  INSERT INTO booking (number_of_guests, date, name) VALUES (1, '2021-02-15 9:55:12', 'test'); 

/*
SELECT SUM(number_of_guests) 
FROM booking 
WHERE date BETWEEN "2021-02-14" AND "2021-02-16"; ; 
*/

$adresseBdd = new PDO('mysql:host=localhost;dbname=restaurantarnaudmichant;charset=utf8', 'root', '');

$_GET['day'] = date('l', strtotime(date("Y-m-d")));     // ligne pour test à supprimer
$_GET['open'] = '2021-02-14';
$_GET['close'] = '2021-02-16'; // on doit retirer 1h
$_GET['nombreDePersonne'] = 6;
$_GET['dateReservation'] = '2021-02-16 12:30:00';
$_GET['nomReservation'] = 'Test';
$_GET['allergyList'] = [1, 2, 7];

function ConvertionDateEnFrancais(){
    
    $day = date('l', strtotime($_GET['day']));
    $day = $_GET['day'];

    return $day = match($day){
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi',
        'Sunday' => 'Dimanche',
        default => 'error'
    };
}

function VerificationRestaurantOuvert($adresseBdd){

    $day = ConvertionDateEnFrancais();

    $sqlJourOuvert= 
    'SELECT active 
    FROM day 
    WHERE name = :day';
    
    $dayStatement = $adresseBdd->prepare($sqlJourOuvert);
    $dayStatement->bindValue(':day', $day, PDO::PARAM_STR);
    
    if ($dayStatement->execute()) {
        $dayOpen = $dayStatement->fetch(PDO::FETCH_NUM);
        $dayOpen = $dayOpen[0];
        if($dayOpen == 0){
              echo  'Jour fermé';
            return false;
        } else {
              echo  'Jour ouvert';
            return true;
        }
    } else {
          echo  'échec de la requete SQL';
        return false;
    }

}

function RecuperationHoraire(){
    $open = $_GET['open'];
    $close = $_GET['close']; // on doit retirer 1h

    return array('open' => $open, 'close' => $close);
}

function RequeteSQLNombreDeReservation($adresseBdd){
    $horaireOuverture = RecuperationHoraire();

    $open = $horaireOuverture['open'];
    $close = $horaireOuverture['close'];

    $sqlSelection= 
    'SELECT SUM(number_of_guests) 
    FROM booking 
    WHERE date 
    BETWEEN :open AND :close';
    
    $bookingStatement = $adresseBdd->prepare($sqlSelection);
    $bookingStatement->bindValue(':open', $open, PDO::PARAM_STR);
    $bookingStatement->bindValue(':close', $close, PDO::PARAM_STR);
    
    if ($bookingStatement->execute()) {
        $numberBooking = $bookingStatement->fetch(PDO::FETCH_NUM);
        $numberBooking = $numberBooking[0];
        $numberBooking;
        return $numberBooking;
    } else {
        return 'échec de la requete SQL';
    }
}

function RequeteSQLNombreDePlaceDeReservation($adresseBdd){
    $sqlNumberOfPlace = 
    'SELECT number_of_place 
    FROM number_of_place';
    
    $numberOfPlaceStatement = $adresseBdd->prepare($sqlNumberOfPlace);
    if ($numberOfPlaceStatement->execute()) {
        $numberOfPlace = $numberOfPlaceStatement->fetch(PDO::FETCH_NUM);
        $numberOfPlace = $numberOfPlace[0];
        return $numberOfPlace;
    } else {
        return 'échec de la requete SQL';
    }
}

function VerificationNombreDePlaceDisponible($numberBooking, $numberOfPlace){
    $numberBooking = $numberBooking += $_GET['nombreDePersonne'];
    if($numberBooking <= $numberOfPlace){
        return true;
    } else {
        return false;
    }
}

function CreationAllergyReservation($adresseBdd, $dernierInsertId){
    $allergyList = $_GET['allergyList'];

    $sqlEnregistrementAllergyReservation = 
    'INSERT INTO booking_allergy (booking_id, allergy_id) 
    VALUES 
    (:bookingId, :allergyId)';
    
    foreach($allergyList as &$value){
        $allergy = $value;

        $enregistrementAllergyStatement = $adresseBdd->prepare($sqlEnregistrementAllergyReservation);
        $enregistrementAllergyStatement->bindValue(':bookingId', $dernierInsertId, PDO::PARAM_STR);
        $enregistrementAllergyStatement->bindValue(':allergyId', $allergy, PDO::PARAM_STR);
    
        try{
            $enregistrementAllergyStatement->execute();
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
            return false;
        }
    }
    return true;
}

function CreationReservation($adresseBdd){
    $nombreDePersonne = $_GET['nombreDePersonne'];
    $dateReservation = $_GET['dateReservation'];
    $nomReservation = $_GET['nomReservation'];
    
    $sqlEnregistrementReservation = 
    'INSERT INTO booking (number_of_guests, date, name) 
    VALUES 
    (:nombreDePersonne, :dateReservation, :nomReservation)';
    
    $enregistrementStatement = $adresseBdd->prepare($sqlEnregistrementReservation);
    $enregistrementStatement->bindValue(':nombreDePersonne', $nombreDePersonne, PDO::PARAM_INT);
    $enregistrementStatement->bindValue(':dateReservation', $dateReservation, PDO::PARAM_STR);
    $enregistrementStatement->bindValue(':nomReservation', $nomReservation, PDO::PARAM_STR);

    try{
        $enregistrementStatement->execute();
        CreationAllergyReservation($adresseBdd, $adresseBdd->lastInsertId());
        return true;
    } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
        return false;
    }
}


if(VerificationRestaurantOuvert($adresseBdd)){
    $numberBooking = RequeteSQLNombreDeReservation($adresseBdd);
    $numberOfPlace = RequeteSQLNombreDePlaceDeReservation($adresseBdd);
    if(VerificationNombreDePlaceDisponible($numberBooking, $numberOfPlace) && CreationReservation($adresseBdd)){
        echo 'Réservation crée';
        return true;
    } else {
        echo 'Impossible de crée la réservation, salle pleine';
        return false;
    }
} else {
    echo 'Restaurant fermé';
    return false;
}
