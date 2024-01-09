<?php

namespace App\Entity;

use App\Repository\CarteProRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteProRepository::class)]
class CartePro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cartePros')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Affectation $affectation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_delivrance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_expiration = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $qrCode_volontaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_volontaire = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct(){
        $this->createdAt= new \DateTimeImmutable();
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

    public function getDateDelivrance(): ?\DateTimeInterface
    {
        return $this->date_delivrance;
    }

    public function setDateDelivrance(\DateTimeInterface $date_delivrance): static
    {
        $this->date_delivrance = $date_delivrance;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(\DateTimeInterface $date_expiration): static
    {
        $this->date_expiration = $date_expiration;

        return $this;
    }

    public function getQrCodeVolontaire(): ?string
    {
        return $this->qrCode_volontaire;
    }

    public function setQrCodeVolontaire(string $qrCode_volontaire): static
    {
        $this->qrCode_volontaire = $qrCode_volontaire;

        return $this;
    }

    public function getPhotoVolontaire(): ?string
    {
        return $this->photo_volontaire;
    }

    public function setPhotoVolontaire(?string $photo_volontaire): static
    {
        $this->photo_volontaire = $photo_volontaire;

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
}
