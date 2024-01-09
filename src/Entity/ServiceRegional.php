<?php

namespace App\Entity;

use App\Repository\ServiceRegionalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRegionalRepository::class)]
class ServiceRegional
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $nom_src = null;


    #[ORM\OneToMany(mappedBy: 'service_regional', targetEntity: ServiceDepartemental::class)]
    private Collection $serviceDepartementals;

    #[ORM\ManyToOne(inversedBy: 'serviceRegionals')]
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

    public function getNomSrc(): ?string
    {
        return $this->nom_src;
    }

    public function setNomSrc(string $nom_src): static
    {
        $this->nom_src = $nom_src;

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
            $serviceDepartemental->setServiceRegional($this);
        }

        return $this;
    }

    public function removeServiceDepartemental(ServiceDepartemental $serviceDepartemental): static
    {
        if ($this->serviceDepartementals->removeElement($serviceDepartemental)) {
            // set the owning side to null (unless already changed)
            if ($serviceDepartemental->getServiceRegional() === $this) {
                $serviceDepartemental->setServiceRegional(null);
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
