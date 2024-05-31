<?php

namespace App\Entity;

use App\Repository\PictureDishesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PictureDishesRepository::class)]
class PictureDishes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le titre ne peut pas être vide')]
    #[Assert\Length(
        max: 100,
        maxMessage: 'Impossible de dépasser les 100 caractéres'
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'picture')]
    private ?Dishes $dishes = null;

    #[ORM\Column]       //#[ORM\Column(nullable: true)]
    private ?bool $display = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getDishes(): ?Dishes
    {
        return $this->dishes;
    }

    public function setDishes(?Dishes $dishes): static
    {
        $this->dishes = $dishes;

        return $this;
    }

    public function isDisplay(): ?bool
    {
        return $this->display;
    }

    public function setDisplay(?bool $display): static
    {
        $this->display = $display;

        return $this;
    }
}
