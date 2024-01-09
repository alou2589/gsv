<?php

namespace App\Entity;

use App\Repository\VolontaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\Inflector\Rules\Pattern;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VolontaireRepository::class)]
class Volontaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu_naissance = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 9)]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'volontaire', targetEntity: StatutVolontaire::class, orphanRemoval: true)]
    private Collection $statutVolontaires;

    #[ORM\Column(length: 255)]
    private ?string $numero_cin = null;

    #[ORM\OneToMany(mappedBy: 'volontaire', targetEntity: Contrat::class)]
    private Collection $contrats;
    
    public function __construct(){
        $this->createdAt= new \DateTimeImmutable();
        $this->statutVolontaires = new ArrayCollection();
        $this->contrats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieu_naissance;
    }

    public function setLieuNaissance(string $lieu_naissance): static
    {
        $this->lieu_naissance = $lieu_naissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, StatutVolontaire>
     */
    public function getStatutVolontaires(): Collection
    {
        return $this->statutVolontaires;
    }

    public function addStatutVolontaire(StatutVolontaire $statutVolontaire): static
    {
        if (!$this->statutVolontaires->contains($statutVolontaire)) {
            $this->statutVolontaires->add($statutVolontaire);
            $statutVolontaire->setVolontaire($this);
        }

        return $this;
    }

    public function removeStatutVolontaire(StatutVolontaire $statutVolontaire): static
    {
        if ($this->statutVolontaires->removeElement($statutVolontaire)) {
            // set the owning side to null (unless already changed)
            if ($statutVolontaire->getVolontaire() === $this) {
                $statutVolontaire->setVolontaire(null);
            }
        }

        return $this;
    }

    public function getNumeroCin(): ?string
    {
        return $this->numero_cin;
    }

    public function setNumeroCin(string $numero_cin): static
    {
        $this->numero_cin = $numero_cin;

        return $this;
    }

    /**
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): static
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->setVolontaire($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): static
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getVolontaire() === $this) {
                $contrat->setVolontaire(null);
            }
        }

        return $this;
    }
}
