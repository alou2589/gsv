<?php

namespace App\Entity;

use App\Repository\JustificationAbsenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JustificationAbsenceRepository::class)]
class JustificationAbsence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'justificationAbsences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Affectation $affectation = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_jours_absence = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $date_debut = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $date_fin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $upload_justificatif = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status_validation = null;

    #[ORM\ManyToOne(inversedBy: 'justificationAbsences')]
    private ?User $operateur = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $date_justification = null;

    #[ORM\Column(length: 255)]
    private ?string $type_justificatif = null;

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

    public function getNbJoursAbsence(): ?int
    {
        return $this->nb_jours_absence;
    }

    public function setNbJoursAbsence(?int $nb_jours_absence): static
    {
        $this->nb_jours_absence = $nb_jours_absence;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeImmutable $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeImmutable $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getUploadJustificatif(): ?string
    {
        return $this->upload_justificatif;
    }

    public function setUploadJustificatif(?string $upload_justificatif): static
    {
        $this->upload_justificatif = $upload_justificatif;

        return $this;
    }

    public function getStatusValidation(): ?string
    {
        return $this->status_validation;
    }

    public function setStatusValidation(?string $status_validation): static
    {
        $this->status_validation = $status_validation;

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

    public function getDateJustification(): ?\DateTimeImmutable
    {
        return $this->date_justification;
    }

    public function setDateJustification(?\DateTimeImmutable $date_justification): static
    {
        $this->date_justification = $date_justification;

        return $this;
    }

    public function getTypeJustificatif(): ?string
    {
        return $this->type_justificatif;
    }

    public function setTypeJustificatif(string $type_justificatif): static
    {
        $this->type_justificatif = $type_justificatif;

        return $this;
    }
}
