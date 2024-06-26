<?php

namespace App\Entity;

use App\Repository\DayRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotNull(message: 'l\'heure ne peut pas être vide')]
    private ?\DateTimeInterface $openAM = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull(message: 'l\'heure ne peut pas être vide')]
    private ?\DateTimeInterface $closeAM = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull(message: 'l\'heure ne peut pas être vide')]
    private ?\DateTimeInterface $openPM = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull(message: 'l\'heure ne peut pas être vide')]
    private ?\DateTimeInterface $closePM = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide')]
    #[Assert\Length(
        max: 50,
        maxMessage: 'Impossible de dépasser les 50 caractéres'
    )]
    private ?string $name = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
