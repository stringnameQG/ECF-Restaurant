<?php

namespace App\Entity;

use App\Repository\AdditionalInformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdditionalInformationRepository::class)]
class AdditionalInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numberOfGuests = null;

    #[ORM\Column(length: 100)]
    private ?string $defaultName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOfGuests(): ?int
    {
        return $this->numberOfGuests;
    }

    public function setNumberOfGuests(int $numberOfGuests): static
    {
        $this->numberOfGuests = $numberOfGuests;

        return $this;
    }

    public function getDefaultName(): ?string
    {
        return $this->defaultName;
    }

    public function setDefaultName(string $defaultName): static
    {
        $this->defaultName = $defaultName;

        return $this;
    }
}
