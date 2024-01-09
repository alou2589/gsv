<?php

namespace App\Entity;

use App\Repository\TypeContratRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeContratRepository::class)]
class TypeContrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_type_contrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeContrat(): ?string
    {
        return $this->nom_type_contrat;
    }

    public function setNomTypeContrat(string $nom_type_contrat): static
    {
        $this->nom_type_contrat = $nom_type_contrat;

        return $this;
    }
}
