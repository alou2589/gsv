<?php

namespace App\Entity;

use App\Repository\BilanVolontaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BilanVolontaireRepository::class)]
class BilanVolontaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bilanVolontaires')]
    private ?Affectation $affectation = null;

    #[ORM\Column(nullable:true)]
    private ?int $nbjour_presence = null;

    #[ORM\Column(nullable:true)]
    private ?int $nbjour_absence = null;

    #[ORM\Column(nullable:true)]
    private ?int $mois = null;

    #[ORM\Column(nullable:true)]
    private ?int $nb_jours_ouvrables = null;

    #[ORM\OneToMany(mappedBy: 'bilan_volontaire', targetEntity: BulletinVolontaire::class, orphanRemoval: true)]
    private Collection $bulletinVolontaires;

    #[ORM\Column(nullable:true)]
    private ?int $annee = null;

    public function __construct()
    {
        $this->bulletinVolontaires = new ArrayCollection();
    }
  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAffectation(): ?Affectation
    {
        return $this->affectation;
    }

    public function setAffectation(?Affectation $affectation): static
    {
        $this->affectation = $affectation;

        return $this;
    }

    public function getNbjourPresence(): ?int
    {
        return $this->nbjour_presence;
    }

    public function setNbjourPresence(int $nbjour_presence): static
    {
        $this->nbjour_presence = $nbjour_presence;

        return $this;
    }

    public function getNbjourAbsence(): ?int
    {
        return $this->nbjour_absence;
    }

    public function setNbjourAbsence(int $nbjour_absence): static
    {
        $this->nbjour_absence = $nbjour_absence;

        return $this;
    }

    public function getMois(): ?int
    {
        return $this->mois;
    }

    public function setMois(int $mois): static
    {
        $this->mois = $mois;

        return $this;
    }

    public function getNbJoursOuvrables(): ?int
    {
        return $this->nb_jours_ouvrables;
    }

    public function setNbJoursOuvrables(int $nb_jours_ouvrables): static
    {
        $this->nb_jours_ouvrables = $nb_jours_ouvrables;

        return $this;
    }

    /**
     * @return Collection<int, BulletinVolontaire>
     */
    public function getBulletinVolontaires(): Collection
    {
        return $this->bulletinVolontaires;
    }

    public function addBulletinVolontaire(BulletinVolontaire $bulletinVolontaire): static
    {
        if (!$this->bulletinVolontaires->contains($bulletinVolontaire)) {
            $this->bulletinVolontaires->add($bulletinVolontaire);
            $bulletinVolontaire->setBilanVolontaire($this);
        }

        return $this;
    }

    public function removeBulletinVolontaire(BulletinVolontaire $bulletinVolontaire): static
    {
        if ($this->bulletinVolontaires->removeElement($bulletinVolontaire)) {
            // set the owning side to null (unless already changed)
            if ($bulletinVolontaire->getBilanVolontaire() === $this) {
                $bulletinVolontaire->setBilanVolontaire(null);
            }
        }

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }
}
