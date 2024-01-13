<?php

namespace App\Entity;

use App\Repository\AffectationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffectationRepository::class)]
class Affectation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StatutVolontaire $volontaire_statut = null;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ServiceDepartemental $service_departemental = null;

    #[ORM\ManyToOne(inversedBy: 'affectations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Poste $poste = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_affectation = null;

    #[ORM\OneToMany(mappedBy: 'affectation', targetEntity: CartePro::class, orphanRemoval: true)]
    private Collection $cartePros;

    #[ORM\OneToMany(mappedBy: 'affectation', targetEntity: Emargement::class, orphanRemoval: true)]
    private Collection $emargements;

    #[ORM\OneToMany(mappedBy: 'affectation', targetEntity: BilanVolontaire::class, orphanRemoval: true)]
    private Collection $bilanVolontaires;

    public function __construct()
    {
        $this->cartePros = new ArrayCollection();
        $this->emargements = new ArrayCollection();
        $this->bilanVolontaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVolontaireStatut(): ?StatutVolontaire
    {
        return $this->volontaire_statut;
    }

    public function setVolontaireStatut(?StatutVolontaire $volontaire_statut): static
    {
        $this->volontaire_statut = $volontaire_statut;

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

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getDateAffectation(): ?\DateTimeInterface
    {
        return $this->date_affectation;
    }

    public function setDateAffectation(\DateTimeInterface $date_affectation): static
    {
        $this->date_affectation = $date_affectation;

        return $this;
    }

    /**
     * @return Collection<int, CartePro>
     */
    public function getCartePros(): Collection
    {
        return $this->cartePros;
    }

    public function addCartePro(CartePro $cartePro): static
    {
        if (!$this->cartePros->contains($cartePro)) {
            $this->cartePros->add($cartePro);
            $cartePro->setAffectation($this);
        }

        return $this;
    }

    public function removeCartePro(CartePro $cartePro): static
    {
        if ($this->cartePros->removeElement($cartePro)) {
            // set the owning side to null (unless already changed)
            if ($cartePro->getAffectation() === $this) {
                $cartePro->setAffectation(null);
            }
        }

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
            $emargement->setAffectation($this);
        }

        return $this;
    }

    public function removeEmargement(Emargement $emargement): static
    {
        if ($this->emargements->removeElement($emargement)) {
            // set the owning side to null (unless already changed)
            if ($emargement->getAffectation() === $this) {
                $emargement->setAffectation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BilanVolontaire>
     */
    public function getBilanVolontaires(): Collection
    {
        return $this->bilanVolontaires;
    }

    public function addBilanVolontaire(BilanVolontaire $bilanVolontaire): static
    {
        if (!$this->bilanVolontaires->contains($bilanVolontaire)) {
            $this->bilanVolontaires->add($bilanVolontaire);
            $bilanVolontaire->setAffectation($this);
        }

        return $this;
    }

    public function removeBilanVolontaire(BilanVolontaire $bilanVolontaire): static
    {
        if ($this->bilanVolontaires->removeElement($bilanVolontaire)) {
            // set the owning side to null (unless already changed)
            if ($bilanVolontaire->getAffectation() === $this) {
                $bilanVolontaire->setAffectation(null);
            }
        }

        return $this;
    }
}
