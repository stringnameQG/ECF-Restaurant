<?php

namespace App\Entity;

use App\Repository\CateringServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CateringServiceRepository::class)]
class CateringService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfGuests = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOpen = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateClose = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOfGuests(): ?int
    {
        return $this->numberOfGuests;
    }

    public function setNumberOfGuests(?int $numberOfGuests): static
    {
        $this->numberOfGuests = $numberOfGuests;

        return $this;
    }

    public function getDateOpen(): ?\DateTimeInterface
    {
        return $this->dateOpen;
    }

    public function setDateOpen(\DateTimeInterface $dateOpen): static
    {
        $this->dateOpen = $dateOpen;

        return $this;
    }

    public function getDateClose(): ?\DateTimeInterface
    {
        return $this->dateClose;
    }

    public function setDateClose(\DateTimeInterface $dateClose): static
    {
        $this->dateClose = $dateClose;

        return $this;
    }
}
