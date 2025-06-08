<?php

namespace App\Entity;

use App\Repository\RegionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionsRepository::class)]
class Regions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, Organizations>
     */
    #[ORM\OneToMany(targetEntity: Organizations::class, mappedBy: 'region')]
    private Collection $organizations;

    public function __construct()
    {
        $this->organizations = new ArrayCollection();
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
     * @return Collection<int, Organizations>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(Organizations $organization): static
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations->add($organization);
            $organization->setRegion($this);
        }

        return $this;
    }

    public function removeOrganization(Organizations $organization): static
    {
        if ($this->organizations->removeElement($organization)) {
            // set the owning side to null (unless already changed)
            if ($organization->getRegion() === $this) {
                $organization->setRegion(null);
            }
        }

        return $this;
    }
}
