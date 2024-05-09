<?php

namespace App\Entity;

use App\Repository\DayRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DayRepository::class)]
class Day
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openAM = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closeAM = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openPM = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closePM = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getOpenAM(): ?\DateTimeInterface
    {
        return $this->openAM;
    }

    public function setOpenAM(\DateTimeInterface $openAM): static
    {
        $this->openAM = $openAM;

        return $this;
    }

    public function getCloseAM(): ?\DateTimeInterface
    {
        return $this->closeAM;
    }

    public function setCloseAM(\DateTimeInterface $closeAM): static
    {
        $this->closeAM = $closeAM;

        return $this;
    }

    public function getOpenPM(): ?\DateTimeInterface
    {
        return $this->openPM;
    }

    public function setOpenPM(\DateTimeInterface $openPM): static
    {
        $this->openPM = $openPM;

        return $this;
    }

    public function getClosePM(): ?\DateTimeInterface
    {
        return $this->closePM;
    }

    public function setClosePM(\DateTimeInterface $closePM): static
    {
        $this->closePM = $closePM;

        return $this;
    }
}
