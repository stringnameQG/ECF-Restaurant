<?php

namespace App\Entity;

use App\Repository\NumberOfPlaceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NumberOfPlaceRepository::class)]
class NumberOfPlace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: 'Le nombre de personnes ne peut pas être vide ou inférieur à zéro')]
    private ?int $numberOfPlace = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOfPlace(): ?int
    {
        return $this->numberOfPlace;
    }

    public function setNumberOfPlace(int $numberOfPlace): static
    {
        $this->numberOfPlace = $numberOfPlace;

        return $this;
    }
}
