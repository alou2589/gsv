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

    #[ORM\Column(length: 255, unique:true)]
    private ?string $nom_region = null;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: ServiceRegional::class, orphanRemoval: true)]
    private Collection $serviceRegionals;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Departements::class, orphanRemoval: true)]
    private Collection $departements;

    public function __construct()
    {
        $this->serviceRegionals = new ArrayCollection();
        $this->departements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRegion(): ?string
    {
        return $this->nom_region;
    }

    public function setNomRegion(string $nom_region): static
    {
        $this->nom_region = $nom_region;

        return $this;
    }

    /**
     * @return Collection<int, ServiceRegional>
     */
    public function getServiceRegionals(): Collection
    {
        return $this->serviceRegionals;
    }

    public function addServiceRegional(ServiceRegional $serviceRegional): static
    {
        if (!$this->serviceRegionals->contains($serviceRegional)) {
            $this->serviceRegionals->add($serviceRegional);
            $serviceRegional->setRegion($this);
        }

        return $this;
    }

    public function removeServiceRegional(ServiceRegional $serviceRegional): static
    {
        if ($this->serviceRegionals->removeElement($serviceRegional)) {
            // set the owning side to null (unless already changed)
            if ($serviceRegional->getRegion() === $this) {
                $serviceRegional->setRegion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Departements>
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departements $departement): static
    {
        if (!$this->departements->contains($departement)) {
            $this->departements->add($departement);
            $departement->setRegion($this);
        }

        return $this;
    }

    public function removeDepartement(Departements $departement): static
    {
        if ($this->departements->removeElement($departement)) {
            // set the owning side to null (unless already changed)
            if ($departement->getRegion() === $this) {
                $departement->setRegion(null);
            }
        }

        return $this;
    }
}
