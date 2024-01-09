<?php

namespace App\Entity;

use App\Repository\DepartementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementsRepository::class)]
class Departements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_departement = null;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: ServiceDepartemental::class, orphanRemoval: true)]
    private Collection $serviceDepartementals;

    #[ORM\ManyToOne(inversedBy: 'departements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Regions $region = null;

    public function __construct()
    {
        $this->serviceDepartementals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDepartement(): ?string
    {
        return $this->nom_departement;
    }

    public function setNomDepartement(string $nom_departement): static
    {
        $this->nom_departement = $nom_departement;

        return $this;
    }

    /**
     * @return Collection<int, ServiceDepartemental>
     */
    public function getServiceDepartementals(): Collection
    {
        return $this->serviceDepartementals;
    }

    public function addServiceDepartemental(ServiceDepartemental $serviceDepartemental): static
    {
        if (!$this->serviceDepartementals->contains($serviceDepartemental)) {
            $this->serviceDepartementals->add($serviceDepartemental);
            $serviceDepartemental->setDepartement($this);
        }

        return $this;
    }

    public function removeServiceDepartemental(ServiceDepartemental $serviceDepartemental): static
    {
        if ($this->serviceDepartementals->removeElement($serviceDepartemental)) {
            // set the owning side to null (unless already changed)
            if ($serviceDepartemental->getDepartement() === $this) {
                $serviceDepartemental->setDepartement(null);
            }
        }

        return $this;
    }

    public function getRegion(): ?Regions
    {
        return $this->region;
    }

    public function setRegion(?Regions $region): static
    {
        $this->region = $region;

        return $this;
    }
}
