<?php

namespace App\Entity;

use App\Repository\BulletinVolontaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BulletinVolontaireRepository::class)]
class BulletinVolontaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $paie_presence = null;

    #[ORM\Column]
    private ?int $paie_absence = null;

    #[ORM\Column]
    private ?int $forfait = null;

    #[ORM\ManyToOne(inversedBy: 'bulletinVolontaires')]
    private ?BilanVolontaire $bilan_volontaire = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_paie = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaiePresence(): ?int
    {
        return $this->paie_presence;
    }

    public function setPaiePresence(int $paie_presence): static
    {
        $this->paie_presence = $paie_presence;

        return $this;
    }

    public function getPaieAbsence(): ?int
    {
        return $this->paie_absence;
    }

    public function setPaieAbsence(int $paie_absence): static
    {
        $this->paie_absence = $paie_absence;

        return $this;
    }

    public function getForfait(): ?int
    {
        return $this->forfait;
    }

    public function setForfait(int $forfait): static
    {
        $this->forfait = $forfait;

        return $this;
    }

    public function getBilanVolontaire(): ?BilanVolontaire
    {
        return $this->bilan_volontaire;
    }

    public function setBilanVolontaire(?BilanVolontaire $bilan_volontaire): static
    {
        $this->bilan_volontaire = $bilan_volontaire;

        return $this;
    }

    public function getTotalPaie(): ?int
    {
        return $this->total_paie;
    }

    public function setTotalPaie(?int $total_paie): static
    {
        $this->total_paie = $total_paie;

        return $this;
    }

}
