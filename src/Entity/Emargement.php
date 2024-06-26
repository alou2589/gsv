<?php

namespace App\Entity;

use App\Repository\EmargementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: EmargementRepository::class)]
class Emargement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\ManyToOne(inversedBy: 'emargements')]
    private ?Affectation $affectation = null;

    #[ORM\Column(nullable:true)]
    private ?\DateTimeImmutable $heure = null;

    #[ORM\ManyToOne(inversedBy: 'emargements')]
    private ?FeuillePresence $feuille = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat_tp = null;
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

    public function getHeure(): ?\DateTimeImmutable
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeImmutable $heure): static
    {
        $this->heure = $heure;

        return $this;
    }

    public function getFeuille(): ?FeuillePresence
    {
        return $this->feuille;
    }

    public function setFeuille(?FeuillePresence $feuille): static
    {
        $this->feuille = $feuille;

        return $this;
    }

    public function getEtatTp(): ?string
    {
        return $this->etat_tp;
    }

    public function setEtatTp(?string $etat_tp): static
    {
        $this->etat_tp = $etat_tp;

        return $this;
    }
}