<?php

namespace App\Entity;

use App\Repository\StatutVolontaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutVolontaireRepository::class)]
class StatutVolontaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'statutVolontaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Volontaire $volontaire = null;

    #[ORM\Column(length: 255)]
    private ?string $matricule = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_recrutement = null;

    #[ORM\OneToMany(mappedBy: 'volontaire_statut', targetEntity: Affectation::class, orphanRemoval: true)]
    private Collection $affectations;

    #[ORM\OneToMany(mappedBy: 'volontaire_statut', targetEntity: Fichiers::class)]
    private Collection $fichiers;

    public function __construct()
    {
        $this->affectations = new ArrayCollection();
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVolontaire(): ?Volontaire
    {
        return $this->volontaire;
    }

    public function setVolontaire(?Volontaire $volontaire): static
    {
        $this->volontaire = $volontaire;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDateRecrutement(): ?\DateTimeInterface
    {
        return $this->date_recrutement;
    }

    public function setDateRecrutement(\DateTimeInterface $date_recrutement): static
    {
        $this->date_recrutement = $date_recrutement;

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
            $affectation->setVolontaireStatut($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): static
    {
        if ($this->affectations->removeElement($affectation)) {
            // set the owning side to null (unless already changed)
            if ($affectation->getVolontaireStatut() === $this) {
                $affectation->setVolontaireStatut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fichiers>
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichiers $fichier): static
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers->add($fichier);
            $fichier->setVolontaireStatut($this);
        }

        return $this;
    }

    public function removeFichier(Fichiers $fichier): static
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getVolontaireStatut() === $this) {
                $fichier->setVolontaireStatut(null);
            }
        }

        return $this;
    }
    
}
