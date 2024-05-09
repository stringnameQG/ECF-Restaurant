<?php

namespace App\Entity;

use App\Repository\DishesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishesRepository::class)]
class Dishes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?bool $bestDishes = null;

    /**
     * @var Collection<int, PictureDishes>
     */
    #[ORM\OneToMany(targetEntity: PictureDishes::class, mappedBy: 'dishes')]
    private Collection $PictureDishes;

    #[ORM\ManyToOne(inversedBy: 'dishes')]
    private ?Category $Category = null;

    public function __construct()
    {
        $this->PictureDishes = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isBestDishes(): ?bool
    {
        return $this->bestDishes;
    }

    public function setBestDishes(bool $bestDishes): static
    {
        $this->bestDishes = $bestDishes;

        return $this;
    }

    /**
     * @return Collection<int, PictureDishes>
     */
    public function getPictureDishes(): Collection
    {
        return $this->PictureDishes;
    }

    public function addPictureDish(PictureDishes $pictureDish): static
    {
        if (!$this->PictureDishes->contains($pictureDish)) {
            $this->PictureDishes->add($pictureDish);
            $pictureDish->setDishes($this);
        }

        return $this;
    }

    public function removePictureDish(PictureDishes $pictureDish): static
    {
        if ($this->PictureDishes->removeElement($pictureDish)) {
            // set the owning side to null (unless already changed)
            if ($pictureDish->getDishes() === $this) {
                $pictureDish->setDishes(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): static
    {
        $this->Category = $Category;

        return $this;
    }
}
