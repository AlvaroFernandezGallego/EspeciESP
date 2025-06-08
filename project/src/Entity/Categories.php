<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, Species>
     */
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Species::class)]
    private Collection $species;

    public function __construct()
    {
        $this->species = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Species>
     */
    public function getSpecies(): Collection
    {
        return $this->species;
    }

    public function addSpecies(Species $species): static
    {
        if (!$this->species->contains($species)) 
        {
            $this->species->add($species);
            $species->setCategory($this);
        }

        return $this;
    }

    public function removeSpecies(Species $species): static
    {
        if ($this->species->removeElement($species)) 
        {
            if ($species->getCategory() === $this) 
            {
                $species->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}