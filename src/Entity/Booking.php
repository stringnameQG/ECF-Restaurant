<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: 'Le nombre de personne ne peut pas être vide ou inférieur à zéro')]
    private ?int $numberOfGuests = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: 'L\'heure de réservation ne peut pas être vide')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom de réservation ne peut pas être vide')]
    #[Assert\Length(
        max: 100,
        maxMessage: 'Impossible de dépasser les 100 caractéres'
    )]
    private ?string $name = null;

    /**
     * @var Collection<int, Allergy>
     */
    #[ORM\ManyToMany(targetEntity: Allergy::class, inversedBy: 'bookings')]
    private Collection $Allergy;

    public function __construct()
    {
        $this->Allergy = new ArrayCollection();
    }

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    /**
     * @return Collection<int, Allergy>
     */
    public function getAllergy(): Collection
    {
        return $this->Allergy;
    }

    public function addAllergy(Allergy $allergy): static
    {
        if (!$this->Allergy->contains($allergy)) {
            $this->Allergy->add($allergy);
        }

        return $this;
    }

    public function removeAllergy(Allergy $allergy): static
    {
        $this->Allergy->removeElement($allergy);

        return $this;
    }
}
