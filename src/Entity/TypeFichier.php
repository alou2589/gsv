<?php

namespace App\Entity;

use App\Repository\TypeFichierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeFichierRepository::class)]
class TypeFichier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type_fichier = null;

    #[ORM\OneToMany(mappedBy: 'type_fichier', targetEntity: Fichiers::class)]
    private Collection $fichiers;

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeFichier(): ?string
    {
        return $this->nom_type_fichier;
    }

    public function setNomTypeFichier(string $nom_type_fichier): static
    {
        $this->nom_type_fichier = $nom_type_fichier;

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
            $fichier->setTypeFichier($this);
        }

        return $this;
    }

    public function removeFichier(Fichiers $fichier): static
    {
        if ($this->fichiers->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getTypeFichier() === $this) {
                $fichier->setTypeFichier(null);
            }
        }

        return $this;
    }
}
