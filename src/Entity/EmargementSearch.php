<?php
namespace App\Entity;

class EmargementSearch {
    private ?\DateTimeImmutable $chosenDate=null;
    private ?string $chosenSdc=null;
    
    public function getChosenDate(): ?\DateTimeImmutable
    {
        return $this->chosenDate;
    }

    public function setChosenDate(\DateTimeImmutable $chosenDate): static
    {
        $this->chosenDate = $chosenDate;

        return $this;
    }
    
    public function getChosenSdc(): ?string
    {
        return $this->chosenSdc;
    }

    public function setChosenSdc(string $chosenSdc): static
    {
        $this->chosenSdc = $chosenSdc;

        return $this;
    }
}