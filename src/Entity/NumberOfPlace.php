<?php

namespace App\Entity;

use App\Repository\NumberOfPlaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NumberOfPlaceRepository::class)]
class NumberOfPlace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
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
