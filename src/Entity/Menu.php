<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $active = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'menus')]
    private Collection $Category;

    /**
     * @var Collection<int, Formula>
     */
    #[ORM\ManyToMany(targetEntity: Formula::class, inversedBy: 'menus')]
    private Collection $Formula;

    public function __construct()
    {
        $this->Category = new ArrayCollection();
        $this->Formula = new ArrayCollection();
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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->Category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->Category->contains($category)) {
            $this->Category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->Category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Formula>
     */
    public function getFormula(): Collection
    {
        return $this->Formula;
    }

    public function addFormula(Formula $formula): static
    {
        if (!$this->Formula->contains($formula)) {
            $this->Formula->add($formula);
        }

        return $this;
    }

    public function removeFormula(Formula $formula): static
    {
        $this->Formula->removeElement($formula);

        return $this;
    }
}
