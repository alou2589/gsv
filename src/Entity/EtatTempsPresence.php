<?php

namespace App\Entity;

use App\Repository\EtatTempsPresenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatTempsPresenceRepository::class)]
class EtatTempsPresence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_etat_tp = null;

    #[ORM\OneToMany(mappedBy: 'etat_tp', targetEntity: Emargement::class)]
    private Collection $emargements;

    public function __construct()
    {
        $this->emargements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEtatTp(): ?string
    {
        return $this->nom_etat_tp;
    }

    public function setNomEtatTp(string $nom_etat_tp): static
    {
        $this->nom_etat_tp = $nom_etat_tp;

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
            $emargement->setEtatTp($this);
        }

        return $this;
    }

    public function removeEmargement(Emargement $emargement): static
    {
        if ($this->emargements->removeElement($emargement)) {
            // set the owning side to null (unless already changed)
            if ($emargement->getEtatTp() === $this) {
                $emargement->setEtatTp(null);
            }
        }

        return $this;
    }
}
