<?php

namespace App\Entity;

use App\Repository\ServiceDepartementalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceDepartementalRepository::class)]
class ServiceDepartemental
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'serviceDepartementals')]
    private ?ServiceRegional $service_regional = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $nom_sdc = null;

    #[ORM\ManyToOne(inversedBy: 'serviceDepartementals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departements $departement = null;

    #[ORM\OneToMany(mappedBy: 'service_departemental', targetEntity: Affectation::class, orphanRemoval: true)]
    private Collection $affectations;

    #[ORM\OneToMany(mappedBy: 'service_departemental', targetEntity: FeuillePresence::class)]
    private Collection $feuillePresences;

    public function __construct()
    {
        $this->affectations = new ArrayCollection();
        $this->feuillePresences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceRegional(): ?ServiceRegional
    {
        return $this->service_regional;
    }

    public function setServiceRegional(?ServiceRegional $service_regional): static
    {
        $this->service_regional = $service_regional;

        return $this;
    }

    public function getNomSdc(): ?string
    {
        return $this->nom_sdc;
    }

    public function setNomSdc(string $nom_sdc): static
    {
        $this->nom_sdc = $nom_sdc;

        return $this;
    }

    public function getDepartement(): ?Departements
    {
        return $this->departement;
    }

    public function setDepartement(?Departements $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection<int, Affectation>
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): static
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations->add($affectation);
            $affectation->setServiceDepartemental($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): static
    {
        if ($this->affectations->removeElement($affectation)) {
            // set the owning side to null (unless already changed)
            if ($affectation->getServiceDepartemental() === $this) {
                $affectation->setServiceDepartemental(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FeuillePresence>
     */
    public function getFeuillePresences(): Collection
    {
        return $this->feuillePresences;
    }

    public function addFeuillePresence(FeuillePresence $feuillePresence): static
    {
        if (!$this->feuillePresences->contains($feuillePresence)) {
            $this->feuillePresences->add($feuillePresence);
            $feuillePresence->setServiceDepartemental($this);
        }

        return $this;
    }

    public function removeFeuillePresence(FeuillePresence $feuillePresence): static
    {
        if ($this->feuillePresences->removeElement($feuillePresence)) {
            // set the owning side to null (unless already changed)
            if ($feuillePresence->getServiceDepartemental() === $this) {
                $feuillePresence->setServiceDepartemental(null);
            }
        }

        return $this;
    }

}
