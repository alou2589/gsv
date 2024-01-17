<?php

namespace App\Entity;

use App\Repository\FeuillePresenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeuillePresenceRepository::class)]
class FeuillePresence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $numero_feuille = null;

    #[ORM\ManyToOne(inversedBy: 'feuillePresences')]
    private ?ServiceDepartemental $service_departemental = null;

    #[ORM\ManyToOne(inversedBy: 'feuillePresences')]
    private ?User $operateur = null;

    #[ORM\OneToMany(mappedBy: 'feuille', targetEntity: Emargement::class, orphanRemoval:true)]
    private Collection $emargements;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $active = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $date_feuille = null;

    public function __construct()
    {
        $this->emargements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroFeuille(): ?string
    {
        return $this->numero_feuille;
    }

    public function setNumeroFeuille(string $numero_feuille): static
    {
        $this->numero_feuille = $numero_feuille;

        return $this;
    }

    public function getServiceDepartemental(): ?ServiceDepartemental
    {
        return $this->service_departemental;
    }

    public function setServiceDepartemental(?ServiceDepartemental $service_departemental): static
    {
        $this->service_departemental = $service_departemental;

        return $this;
    }

    public function getOperateur(): ?User
    {
        return $this->operateur;
    }

    public function setOperateur(?User $operateur): static
    {
        $this->operateur = $operateur;

        return $this;
    }

    /**
     * @return Collection<int, Emargement>
     */
    public function getEmargements(): Collection
    {
        return $this->emargements;
    }

    public function addEmargement(Emargement $emargement): static
    {
        if (!$this->emargements->contains($emargement)) {
            $this->emargements->add($emargement);
            $emargement->setFeuille($this);
        }

        return $this;
    }

    public function removeEmargement(Emargement $emargement): static
    {
        if ($this->emargements->removeElement($emargement)) {
            // set the owning side to null (unless already changed)
            if ($emargement->getFeuille() === $this) {
                $emargement->setFeuille(null);
            }
        }

        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active;
    }

    public function setActive(string $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getDateFeuille(): ?\DateTimeImmutable
    {
        return $this->date_feuille;
    }

    public function setDateFeuille(?\DateTimeImmutable $date_feuille): static
    {
        $this->date_feuille = $date_feuille;

        return $this;
    }

}
