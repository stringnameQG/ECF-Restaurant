<?php

namespace App\Entity;

use App\Repository\AdditionalInformationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdditionalInformationRepository::class)]
class AdditionalInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le nombre de personne par défaut ne peut pas être vide')]
    private ?int $numberOfGuests = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom par défaut ne peut pas être vide')]
    #[Assert\Length(
        max: 100,
        maxMessage: 'Impossible de dépasser les 100 caractéres'
    )]
    private ?string $defaultName = null;

    #[ORM\OneToOne(mappedBy: 'AdditionalInformation', cascade: ['persist', 'remove'])]
    private ?User $user = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setAdditionalInformation(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getAdditionalInformation() !== $this) {
            $user->setAdditionalInformation($this);
        }

        $this->user = $user;

        return $this;
    }
}
