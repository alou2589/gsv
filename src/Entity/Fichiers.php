<?php

namespace App\Entity;

use App\Repository\FichiersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichiersRepository::class)]
class Fichiers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fichiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeFichier $type_fichier = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_fichier = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $fichier = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date_enregistrement = null;

    #[ORM\ManyToOne(inversedBy: 'fichiers')]
    private ?StatutVolontaire $volontaire_statut = null;

    public function __construct(){
        $this->date_enregistrement= new \DateTimeImmutable();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeFichier(): ?TypeFichier
    {
        return $this->type_fichier;
    }

    public function setTypeFichier(?TypeFichier $type_fichier): static
    {
        $this->type_fichier = $type_fichier;

        return $this;
    }

    public function getNomFichier(): ?string
    {
        return $this->nom_fichier;
    }

    public function setNomFichier(string $nom_fichier): static
    {
        $this->nom_fichier = $nom_fichier;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): static
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeImmutable
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(\DateTimeImmutable $date_enregistrement): static
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
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
}
